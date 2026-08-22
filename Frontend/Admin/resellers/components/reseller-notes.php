<?php
/**
 * reseller-notes.php — DT Brand's & Jai Hanuman Tex
 * Reseller Internal Staff Memos & Notes Component
 */
$notes = [
    [
        'id' => 'NOTE-101',
        'author' => 'Gautam (Admin)',
        'text' => 'High-trust partner. Always clears credit balance before the 25th of every month. Eligible for ₹2.5L festive season limit hike.',
        'important' => true,
        'date' => '15 Aug 2026'
    ],
    [
        'id' => 'NOTE-102',
        'author' => 'Rajesh (Support)',
        'text' => 'Reseller requested express dropshipping tracking SMS integration for their Surat boutique customers.',
        'important' => false,
        'date' => '02 Aug 2026'
    ]
];
?>

<div class="dt-card" style="padding:18px;">
    <div class="dt-card-head" style="margin-bottom:14px;">
        <h4 class="dt-card-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
            <span>Internal Staff Notes &amp; CRM Memos</span>
        </h4>
        <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="window.showToast('Note added')">+ Add Note</button>
    </div>

    <div style="display:flex; flex-direction:column; gap:10px;">
        <?php foreach ($notes as $n): ?>
            <div style="background:<?php echo $n['important'] ? '#FAF5E8' : '#FAF8F4'; ?>; border:1.2px solid <?php echo $n['important'] ? '#D4AF37' : '#EAE5D9'; ?>; border-radius:10px; padding:12px 14px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                    <div style="display:flex; align-items:center; gap:6px;">
                        <strong style="font-size:0.8rem; color:#181512;"><?php echo htmlspecialchars($n['author']); ?></strong>
                        <?php if ($n['important']): ?>
                            <span class="dt-reseller-badge gold">★ Important Memo</span>
                        <?php endif; ?>
                    </div>
                    <span style="font-size:0.68rem; color:#78716C;"><?php echo $n['date']; ?></span>
                </div>
                <p style="font-size:0.78rem; color:#1F2937; margin:0; line-height:1.4;"><?php echo htmlspecialchars($n['text']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>
