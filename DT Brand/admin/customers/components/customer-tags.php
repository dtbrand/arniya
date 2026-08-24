<?php
/**
 * customer-tags.php — Customer Tagging Studio Component
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */

$master_tags = [
    [
        'id' => 'TAG-01',
        'name' => 'VIP High-Value',
        'color' => 'gold',
        'category' => 'VIP Standing',
        'count' => 312,
        'rule' => 'Lifetime Spend ≥ ₹25,000',
        'type' => 'Auto-Assigned'
    ],
    [
        'id' => 'TAG-02',
        'name' => 'Frequent Buyer',
        'color' => 'green',
        'category' => 'Purchase Velocity',
        'count' => 1850,
        'rule' => 'Completed Orders ≥ 3',
        'type' => 'Auto-Assigned'
    ],
    [
        'id' => 'TAG-03',
        'name' => 'Saree Enthusiast',
        'color' => 'purple',
        'category' => 'Product Affinity',
        'count' => 840,
        'rule' => 'Purchased Silk / Banarasi Sarees',
        'type' => 'Catalog Rule'
    ],
    [
        'id' => 'TAG-04',
        'name' => 'Bridal Lehenga',
        'color' => 'blue',
        'category' => 'Wedding Season',
        'count' => 184,
        'rule' => 'Bridal Category Engagement',
        'type' => 'Catalog Rule'
    ],
    [
        'id' => 'TAG-05',
        'name' => 'Surat Hub Local',
        'color' => 'green',
        'category' => 'Regional Cluster',
        'count' => 1240,
        'rule' => 'State = Gujarat (GJ)',
        'type' => 'Auto-Assigned'
    ],
    [
        'id' => 'TAG-06',
        'name' => 'NRI Global Exporter',
        'color' => 'blue',
        'category' => 'International',
        'count' => 486,
        'rule' => 'Country ≠ India (USA/UAE/UK/CA)',
        'type' => 'Auto-Assigned'
    ],
    [
        'id' => 'TAG-07',
        'name' => 'B2B Wholesale Buyer',
        'color' => 'gold',
        'category' => 'Wholesale Trade',
        'count' => 890,
        'rule' => 'Tier = Wholesaler / Reseller',
        'type' => 'Account Standing'
    ],
    [
        'id' => 'TAG-08',
        'name' => 'Dormant > 60 Days',
        'color' => 'amber',
        'category' => 'Retention Target',
        'count' => 640,
        'rule' => 'Last Order Date > 60 Days',
        'type' => 'Dormancy Engine'
    ],
    [
        'id' => 'TAG-09',
        'name' => 'Festive Silk Seeker',
        'color' => 'purple',
        'category' => 'Seasonal Offer',
        'count' => 512,
        'rule' => 'Festival Broadcast Responder',
        'type' => 'Marketing Action'
    ],
    [
        'id' => 'TAG-10',
        'name' => 'COD Verified',
        'color' => 'green',
        'category' => 'Risk & Trust',
        'count' => 3100,
        'rule' => 'Zero COD RTO History',
        'type' => 'Trust Engine'
    ],
    [
        'id' => 'TAG-11',
        'name' => 'High Return Risk',
        'color' => 'amber',
        'category' => 'Risk Control',
        'count' => 42,
        'rule' => 'Manual Staff Flag',
        'type' => 'Staff Tag'
    ],
    [
        'id' => 'TAG-12',
        'name' => 'Gold Gift Pack Preferred',
        'color' => 'gold',
        'category' => 'Special Request',
        'count' => 95,
        'rule' => 'Manual Packaging Memo',
        'type' => 'Staff Tag'
    ]
];
?>

<!-- ══ CUSTOMER TAGGING STUDIO ══ -->
<div style="display:flex; flex-direction:column; gap:18px;">
    <!-- Quick Tag Creator Card -->
    <div class="dt-card" style="padding:18px 20px;">
        <div class="dt-card-head" style="margin-bottom:14px;">
            <div>
                <h3 class="dt-card-title">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                    <span>Create &amp; Assign Dynamic Customer Tag</span>
                </h3>
                <p style="font-size:0.75rem; color:#78716C; margin:3px 0 0 0;">Create reusable categorization labels for targeted WhatsApp broadcasts, VIP standing, and customer profiles.</p>
            </div>
        </div>

        <form id="dtCreateTagForm" onsubmit="addCustomerTag(event)" style="display:grid; grid-template-columns: minmax(240px, 2fr) minmax(180px, 1fr) minmax(150px, 1fr) auto; gap:12px; align-items:flex-end;">
            <!-- Field 1: Tag Name -->
            <div class="dt-form-group">
                <label class="dt-form-label" style="display:block; font-size:0.73rem; font-weight:800; color:#181512; text-transform:uppercase; letter-spacing:0.03em; margin-bottom:5px;">Tag Name / Label <span style="color:#DC2626;">*</span></label>
                <input type="text" id="dtCustNewTagInput" class="dt-input-field no-icon" placeholder="e.g. Surat High-Volume Silk Buyer, NRI Shopper..." required style="width:100%; height:38px; box-sizing:border-box; background:#FFFFFF; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 12px; font-size:0.8rem;">
            </div>

            <!-- Field 2: Category -->
            <div class="dt-form-group">
                <label class="dt-form-label" style="display:block; font-size:0.73rem; font-weight:800; color:#181512; text-transform:uppercase; letter-spacing:0.03em; margin-bottom:5px;">Category &amp; Usage</label>
                <select id="dtTagCategorySelect" class="dt-cust-select" style="width:100%; height:38px; background:#FFFFFF; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 10px; font-size:0.8rem; font-weight:600; color:#181512;">
                    <option value="VIP Standing">VIP Standing</option>
                    <option value="Product Affinity" selected>Product Affinity</option>
                    <option value="Regional Cluster">Regional Cluster</option>
                    <option value="Wholesale Trade">Wholesale Trade</option>
                    <option value="Seasonal Offer">Seasonal Offer</option>
                    <option value="Risk & Trust">Risk &amp; Trust</option>
                    <option value="Special Request">Special Request</option>
                </select>
            </div>

            <!-- Field 3: Badge Theme -->
            <div class="dt-form-group">
                <label class="dt-form-label" style="display:block; font-size:0.73rem; font-weight:800; color:#181512; text-transform:uppercase; letter-spacing:0.03em; margin-bottom:5px;">Badge Color Theme</label>
                <select id="dtTagColorSelect" class="dt-cust-select" style="width:100%; height:38px; background:#FFFFFF; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 10px; font-size:0.8rem; font-weight:600; color:#181512;">
                    <option value="gold" selected>🟡 Radiant Gold</option>
                    <option value="green">🟢 Emerald Green</option>
                    <option value="blue">🔵 Sapphire Blue</option>
                    <option value="purple">🟣 Royal Purple</option>
                    <option value="amber">🟠 Amber Orange</option>
                </select>
            </div>

            <!-- Field 4: Create Button -->
            <div>
                <button type="submit" class="dt-btn dt-btn-gold" style="display:inline-flex; align-items:center; gap:6px; height:38px; padding:0 18px; white-space:nowrap;">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>Create Tag</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Active Tag Cloud / Quick Filter Pills -->
    <div class="dt-card" style="padding:16px 20px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
            <div style="font-size:0.75rem; font-weight:800; color:#78716C; text-transform:uppercase; letter-spacing:0.04em;">Active Tag Directory Cloud (Click to Filter Table)</div>
            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="padding:3px 10px; font-size:0.72rem;" onclick="filterTagsTable('')">Show All Tags (12)</button>
        </div>
        
        <div class="dt-cust-tags-wrap" id="dtCustTagsContainer" style="gap:8px; display:flex; flex-wrap:wrap;">
            <?php foreach ($master_tags as $t): ?>
                <span class="dt-cust-tag-chip <?php echo htmlspecialchars($t['color']); ?>" style="cursor:pointer;" onclick="filterTagsTable('<?php echo htmlspecialchars($t['name']); ?>')">
                    <span><?php echo htmlspecialchars($t['name']); ?> (<?php echo number_format($t['count']); ?>)</span>
                    <button type="button" class="dt-cust-tag-remove" onclick="event.stopPropagation(); removeTagChip(this, '<?php echo htmlspecialchars($t['name']); ?>')">✕</button>
                </span>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Master Tag Management Table & Search -->
    <div class="dt-card" style="padding:0; overflow:hidden;">
        <!-- Table Toolbar with Dedicated Search Button -->
        <div style="padding:12px 18px; background:#FAF8F4; border-bottom:1.2px solid #EAE5D9; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
            <div style="font-size:0.88rem; font-weight:800; color:#181512; display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                <span>Master Tag Directory &amp; Audience Rules</span>
            </div>
            
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="position:relative; width:250px;">
                    <input type="text" id="dtTagSearchInput" class="dt-input-field no-icon" placeholder="Search tags by name, rule or category..." oninput="document.getElementById('dtTagSearchClearBtn').style.display = this.value.trim() ? 'flex' : 'none'; filterTagsTable(this.value);" onkeyup="filterTagsTable(this.value)" style="height:36px; font-size:0.78rem; padding:0 28px 0 12px; width:100%; box-sizing:border-box; background:#FFFFFF; border:1.2px solid #EAE5D9; border-radius:8px;">
                    <button type="button" id="dtTagSearchClearBtn" onclick="document.getElementById('dtTagSearchInput').value=''; this.style.display='none'; filterTagsTable('');" style="display:none; position:absolute; right:8px; top:50%; transform:translateY(-50%); background:#EAE5D9; border:none; color:#181512; cursor:pointer; font-size:0.68rem; width:18px; height:18px; border-radius:50%; align-items:center; justify-content:center; padding:0;">✕</button>
                </div>
                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="height:36px; padding:0 12px; font-size:0.75rem; display:inline-flex; align-items:center; gap:5px;" onclick="filterTagsTable(document.getElementById('dtTagSearchInput').value)">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <span>Search</span>
                </button>
            </div>
        </div>

        <!-- Table Container -->
        <div style="overflow-x:auto; -webkit-overflow-scrolling:touch; width:100%;">
            <table class="dt-cust-table" id="dtTagsMasterTable" style="width:100%; min-width:780px; border-collapse:collapse;">
                <thead>
                    <tr style="background:#F9F6F0; border-bottom:1.5px solid #EAE5D9;">
                        <th style="padding:10px 16px; font-size:0.72rem; font-weight:800; color:#78716C; text-align:left; text-transform:uppercase;">Tag Badge &amp; Identity</th>
                        <th style="padding:10px 16px; font-size:0.72rem; font-weight:800; color:#78716C; text-align:left; text-transform:uppercase;">Category</th>
                        <th style="padding:10px 16px; font-size:0.72rem; font-weight:800; color:#78716C; text-align:left; text-transform:uppercase;">Assignment Rule</th>
                        <th style="padding:10px 16px; font-size:0.72rem; font-weight:800; color:#78716C; text-align:left; text-transform:uppercase;">Tagged Customers</th>
                        <th style="padding:10px 16px; font-size:0.72rem; font-weight:800; color:#78716C; text-align:right; text-transform:uppercase;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($master_tags as $tag): ?>
                        <tr class="dt-tag-row" data-tag-name="<?php echo htmlspecialchars(strtolower($tag['name'] . ' ' . $tag['category'] . ' ' . $tag['rule'])); ?>" style="border-bottom:1px solid #F1ECE1; transition:background 0.15s ease;">
                            <td style="padding:12px 16px;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span class="dt-cust-tag-chip <?php echo htmlspecialchars($tag['color']); ?>">
                                        <span><?php echo htmlspecialchars($tag['name']); ?></span>
                                    </span>
                                    <span style="font-size:0.68rem; color:#78716C; font-weight:600;"><?php echo htmlspecialchars($tag['id']); ?></span>
                                </div>
                            </td>

                            <td style="padding:12px 16px; font-size:0.8rem; font-weight:700; color:#181512;">
                                <?php echo htmlspecialchars($tag['category']); ?>
                            </td>

                            <td style="padding:12px 16px;">
                                <div style="font-size:0.75rem; font-weight:700; color:#181512;"><?php echo htmlspecialchars($tag['rule']); ?></div>
                                <span class="dt-cust-badge gold" style="font-size:0.62rem; margin-top:2px; display:inline-block;"><?php echo htmlspecialchars($tag['type']); ?></span>
                            </td>

                            <td style="padding:12px 16px;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <strong style="font-size:0.95rem; font-weight:900; color:#181512;"><?php echo number_format($tag['count']); ?></strong>
                                    <div style="flex:1; max-width:80px; height:6px; background:#EAE5D9; border-radius:3px; overflow:hidden;">
                                        <div style="width:<?php echo min(100, round(($tag['count'] / 1850) * 100)); ?>%; height:100%; background:linear-gradient(90deg, #B8860B, #D4AF37); border-radius:3px;"></div>
                                    </div>
                                </div>
                            </td>

                            <td style="padding:12px 16px; text-align:right;">
                                <div style="display:inline-flex; align-items:center; gap:6px;">
                                    <a href="/DT%20Brand/admin/customers/index.php" class="dt-btn dt-btn-pale dt-btn-sm" style="padding:3px 8px; font-size:0.72rem; text-decoration:none;" title="View Tagged Customers">
                                        View Customers
                                    </a>
                                    <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px; padding:3px 8px; font-size:0.72rem;" onclick="broadcastToTaggedGroup('<?php echo htmlspecialchars($tag['name']); ?>', <?php echo $tag['count']; ?>)">
                                        <svg viewBox="0 0 24 24" width="11" height="11" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                        <span>Broadcast</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

