<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * customer-notes.php — Internal Staff Notes & Action Items
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 *
 * This pane used to print two invented notes on every customer's dossier, one
 * of them attributed to "Gautam S. (Admin)" and carrying a specific operational
 * instruction ("Always dispatch with DT Brand's silk mark certificate"). Staff
 * reading it would have followed packaging orders that nobody wrote, for a
 * customer who never asked. The save button, meanwhile, only raised a toast.
 *
 * Notes now come from and go to the customer_notes table via
 * /api/customer_notes.php.
 */
require_once __DIR__ . '/../../../src/Database.php';

use DTBrand\Database;

$noteCustId = (int)preg_replace('/[^0-9]/', '', isset($_GET['id']) ? (string)$_GET['id'] : '');
$noteRows = [];
$notesNeedMigration = false;
$notesUnavailable = false;

$pdo = Database::getConnection();
if ($pdo === null || Database::isMockMode()) {
    $notesUnavailable = true;
} elseif ($noteCustId > 0) {
    try {
        $stmt = $pdo->prepare("
            SELECT `id`, `author_name`, `note_text`, `is_important`, `created_at`
            FROM `customer_notes`
            WHERE `customer_id` = ?
            ORDER BY `is_important` DESC, `created_at` DESC, `id` DESC
        ");
        $stmt->execute([$noteCustId]);
        $noteRows = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    } catch (\Exception $e) {
        // The table ships in arniya_master_production.sql but an existing
        // install predates it until the migration is re-run.
        $msg = $e->getMessage();
        if (strpos($msg, '42S02') !== false || stripos($msg, "doesn't exist") !== false) {
            $notesNeedMigration = true;
        } else {
            $notesUnavailable = true;
        }
    }
}
?>

<!-- ══ INTERNAL STAFF NOTES & MEMO PANEL ══ -->
<div class="dt-cust-notes-stream">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:4px;">
        <h4 style="font-size:0.9rem; font-weight:800; color:#181512; margin:0;">Internal Staff Notes</h4>
        <span style="font-size:0.7rem; color:#78716C;">Visible to Admin &amp; Support Staff only</span>
    </div>

    <?php if ($notesNeedMigration): ?>
        <div style="background:#FEF3C7; border:1px solid #FCD34D; border-radius:8px; padding:12px 14px; margin-bottom:12px;">
            <div style="font-size:0.78rem; font-weight:800; color:#8A681F; margin-bottom:4px;">Notes storage not installed yet</div>
            <p style="font-size:0.72rem; color:#645D54; margin:0; line-height:1.5;">
                The <code>customer_notes</code> table does not exist on this database. Run
                <code>database/migrate.php</code> once to create it — the migration is additive and
                will not touch existing data. Notes saved here will persist as soon as it exists.
            </p>
        </div>
    <?php elseif ($notesUnavailable): ?>
        <div style="background:#FEF3C7; border:1px solid #FCD34D; border-radius:8px; padding:12px 14px; margin-bottom:12px;">
            <p style="font-size:0.72rem; color:#645D54; margin:0;">
                The database is unavailable, so existing notes cannot be shown and new ones cannot be saved.
            </p>
        </div>
    <?php endif; ?>

    <!-- Add Note Box -->
    <form onsubmit="addCustomerQuickNote(event)" data-customer-id="<?php echo (int)$noteCustId; ?>"
          style="display:flex; flex-direction:column; gap:8px; margin-bottom:12px;">
        <textarea id="dtCustNewNoteText" class="dt-cust-search-input" style="height:64px; resize:none; padding-left:12px;" placeholder="Write an internal customer memo (e.g. prefers delivery 4-6 PM)..."></textarea>
        <div style="display:flex; align-items:center; justify-content:space-between;">
            <label style="display:inline-flex; align-items:center; gap:6px; font-size:0.72rem; font-weight:700; color:#181512; cursor:pointer;">
                <input type="checkbox" id="dtCustNoteImportantChk">
                <span>Mark as Important Note</span>
            </label>
            <button type="submit" class="dt-btn dt-btn-gold dt-btn-sm">+ Save Staff Note</button>
        </div>
    </form>

    <!-- Notes Stream -->
    <div id="dtCustNotesStream" style="display:flex; flex-direction:column; gap:8px;">
        <?php if (count($noteRows) === 0): ?>
            <p id="dtCustNotesEmpty" style="font-size:0.74rem; color:#8C8478; margin:4px 0 0 0;">
                No internal notes on this customer yet.
            </p>
        <?php else: ?>
            <?php foreach ($noteRows as $n):
                $important = !empty($n['is_important']);
                $when = !empty($n['created_at']) ? date('d M Y', strtotime($n['created_at'])) : '';
            ?>
            <div class="dt-cust-note-card <?php echo $important ? 'important' : ''; ?>">
                <div class="dt-cust-note-head">
                    <span><?php echo htmlspecialchars((string)$n['author_name']); ?><?php echo $when !== '' ? ' • ' . htmlspecialchars($when) : ''; ?></span>
                    <?php if ($important): ?>
                        <span class="dt-status-pill suspended" style="font-size:0.6rem; padding:1px 5px;">★ Important</span>
                    <?php else: ?>
                        <span style="font-size:0.65rem; color:#78716C;">General Note</span>
                    <?php endif; ?>
                </div>
                <div class="dt-cust-note-body"><?php echo nl2br(htmlspecialchars((string)$n['note_text'])); ?></div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
