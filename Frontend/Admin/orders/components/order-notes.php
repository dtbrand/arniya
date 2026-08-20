<?php
/**
 * order-notes.php — Internal Admin Notes Manager Component
 * DT Brand's & Jai Hanuman Tex
 */
$existing_notes = isset($order['notes']) ? [
    ['author' => 'Gautam Sethi (Super Admin)', 'time' => '11:45 AM • Today', 'text' => $order['notes']]
] : [];
?>
<div class="dt-detail-card">
    <div class="dt-detail-card-head">
        <h3 class="dt-detail-card-title">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            <span>Internal Admin Notes</span>
        </h3>
    </div>
    <div class="dt-detail-card-body">
        <div class="dt-notes-list" id="adminNotesList">
            <?php foreach ($existing_notes as $n): ?>
            <div class="dt-note-item">
                <div class="dt-note-header">
                    <span>👤 <?php echo htmlspecialchars($n['author']); ?></span>
                    <span><?php echo htmlspecialchars($n['time']); ?></span>
                </div>
                <div class="dt-note-text"><?php echo nl2br(htmlspecialchars($n['text'])); ?></div>
            </div>
            <?php endforeach; ?>
        </div>

        <div style="display:flex; gap:6px;">
            <input type="text" id="newAdminNoteInput" placeholder="Add confidential internal note..." class="dt-order-search-input" style="height:32px; font-size:11.5px;">
            <button type="button" class="dt-btn dt-btn-gold" style="height:32px; padding:0 12px; font-size:11px;" onclick="window.DT_ORDER_VIEW.addNote()">Add Note</button>
        </div>
    </div>
</div>
