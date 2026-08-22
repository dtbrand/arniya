<?php
/**
 * wholesale-price-list.php — DT Brand's & Jai Hanuman Tex
 * Custom Catalog Price Lists Component
 */
$price_lists = [
    ['id' => 'PL-001', 'name' => 'Master Festive 2026 Wholesale Matrix', 'tier' => 'Platinum Wholesale', 'skus' => 840, 'discount' => '35% Base', 'status' => 'Active', 'badge' => 'emerald'],
    ['id' => 'PL-002', 'name' => 'South India Silk Stockists List', 'tier' => 'Gold Distributor', 'skus' => 420, 'discount' => '28% Base', 'status' => 'Active', 'badge' => 'emerald'],
    ['id' => 'PL-003', 'name' => 'Wedding Season Pure Silk Special', 'tier' => 'Platinum Wholesale', 'skus' => 180, 'discount' => '40% Special', 'status' => 'Active', 'badge' => 'emerald']
];
?>

<div class="dt-card">
    <div class="dt-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
            <h4 class="dt-card-title">Custom Catalog Price Lists</h4>
        </div>
        <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="openCreatePriceListModal()">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            <span>+ Create Price List</span>
        </button>
    </div>

    <div style="padding:16px; display:flex; flex-direction:column; gap:12px;">
        <?php foreach ($price_lists as $pl): ?>
            <div class="dt-pricelist-card">
                <div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <strong style="font-size:0.86rem; color:#181512;"><?php echo htmlspecialchars($pl['name']); ?></strong>
                        <span class="dt-status-pill-clean <?php echo $pl['badge']; ?>">✓ <?php echo $pl['status']; ?></span>
                    </div>
                    <div style="font-size:0.72rem; color:#78716C; margin-top:4px; display:flex; align-items:center; gap:8px;">
                        <span style="font-family:monospace; color:#8A681F; font-weight:800;"><?php echo $pl['id']; ?></span>
                        <span>•</span>
                        <span>Assigned Tier: <strong><?php echo $pl['tier']; ?></strong></span>
                        <span>•</span>
                        <span><?php echo $pl['skus']; ?> Catalogs</span>
                    </div>
                </div>
                <div style="display:flex; align-items:center; gap:10px;">
                    <span class="dt-status-pill-clean gold"><?php echo $pl['discount']; ?></span>
                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('Price List Details Loaded')">Configure</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
