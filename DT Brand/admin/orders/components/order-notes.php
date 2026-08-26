<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * order-notes.php — Smart & Luxury Internal Admin Notes Component
 * DT Brand's & Jai Hanuman Tex
 */
$existing_notes = [
    [
        'id' => 'note_1',
        'author' => 'Gautam Sethi',
        'initials' => 'GS',
        'role' => 'Super Admin',
        'tag' => 'Dispatch Verification',
        'tag_class' => 'gold',
        'time' => '11:45 AM • Today',
        'text' => isset($order['notes']) && $order['notes'] ? $order['notes'] : 'Verified order manifest with warehouse floor. Ready for Surat central dispatch lot.'
    ],
    [
        'id' => 'note_2',
        'author' => 'Suresh Kumar',
        'initials' => 'SK',
        'role' => 'Warehouse Supervisor',
        'tag' => 'QC Passed',
        'tag_class' => 'emerald',
        'time' => '11:35 AM • Today',
        'text' => '100% Handloom Silk Mark certificate barcode inspected and affixed on master parcel carton.'
    ]
];
?>
<div class="dt-detail-card" style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.04); overflow:hidden;">
    <!-- Card Header -->
    <div class="dt-detail-card-head" style="padding:12px 16px; background:#FAF8F4; border-bottom:1.5px solid #E2DFD7; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
        <div style="display:flex; align-items:center; gap:8px;">
            <div style="width:28px; height:28px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F; flex-shrink:0;">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            </div>
            <div>
                <h3 class="dt-detail-card-title" style="margin:0; font-size:13.5px; font-weight:800; color:#181512; display:flex; align-items:center; gap:6px;">
                    <span>Internal Admin Notes</span>
                    <span id="adminNotesCountBadge" style="font-size:10px; font-weight:800; background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; padding:1px 7px; border-radius:12px;"><?php echo count($existing_notes); ?> Notes</span>
                </h3>
            </div>
        </div>
        <div style="display:flex; align-items:center; gap:6px;">
            <span style="font-size:10.5px; font-weight:700; color:#64748B; background:#F1F5F9; border:1px solid #CBD5E1; padding:2px 8px; border-radius:4px; display:inline-flex; align-items:center; gap:4px;">
                <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.3"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                <span>Staff Only • Private</span>
            </span>
        </div>
    </div>

    <!-- Card Body -->
    <div class="dt-detail-card-body" style="padding:14px 16px; display:flex; flex-direction:column; gap:12px;">
        
        <!-- Notes Timeline / Thread List -->
        <div class="dt-notes-list" id="adminNotesList" style="display:flex; flex-direction:column; gap:10px;">
            <?php foreach ($existing_notes as $n): ?>
            <div class="dt-smart-note-card" id="<?php echo $n['id']; ?>" style="background:#FAF8F4; border:1px solid #E2DFD7; border-left:3.5px solid <?php echo ($n['tag_class'] === 'emerald') ? '#15803D' : '#8A681F'; ?>; border-radius:8px; padding:10px 12px; transition:all 0.15s ease;">
                <!-- Note Author Header -->
                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:6px; flex-wrap:wrap; gap:6px;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <div style="width:26px; height:26px; border-radius:50%; background:<?php echo ($n['tag_class'] === 'emerald') ? '#DCFCE7' : '#FAF5E8'; ?>; border:1px solid <?php echo ($n['tag_class'] === 'emerald') ? '#86EFAC' : '#D4AF37'; ?>; color:<?php echo ($n['tag_class'] === 'emerald') ? '#15803D' : '#8A681F'; ?>; font-weight:800; font-size:10px; display:flex; align-items:center; justify-content:center;">
                            <?php echo $n['initials']; ?>
                        </div>
                        <div>
                            <div style="display:flex; align-items:center; gap:6px;">
                                <span style="font-weight:800; font-size:12px; color:#181512;"><?php echo htmlspecialchars($n['author']); ?></span>
                                <span style="font-size:9.5px; font-weight:700; color:#64748B; background:#FFFFFF; border:1px solid #E2DFD7; padding:1px 5px; border-radius:3px;"><?php echo htmlspecialchars($n['role']); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div style="display:flex; align-items:center; gap:6px;">
                        <span style="font-size:9.5px; font-weight:800; text-transform:uppercase; padding:2px 7px; border-radius:4px; letter-spacing:0.3px; background:<?php echo ($n['tag_class'] === 'emerald') ? '#DCFCE7' : '#FAF5E8'; ?>; color:<?php echo ($n['tag_class'] === 'emerald') ? '#15803D' : '#8A681F'; ?>; border:1px solid <?php echo ($n['tag_class'] === 'emerald') ? '#86EFAC' : '#D4AF37'; ?>;">
                            <?php echo htmlspecialchars($n['tag']); ?>
                        </span>
                        <span style="color:#64748B; font-size:10.5px; font-weight:600; display:inline-flex; align-items:center; gap:3px;">
                            <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            <span><?php echo htmlspecialchars($n['time']); ?></span>
                        </span>
                    </div>
                </div>

                <!-- Note Content Text -->
                <div class="dt-note-body-text" style="color:#334155; font-size:12px; line-height:1.45; margin-left:34px; font-weight:500;">
                    <?php echo nl2br(htmlspecialchars($n['text'])); ?>
                </div>

                <!-- Note Action Utilities -->
                <div style="display:flex; justify-content:flex-end; gap:6px; margin-top:6px;">
                    <button type="button" onclick="window.DT_ORDER_VIEW.copyNoteText(this)" class="dt-note-util-btn" style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:4px; padding:2px 6px; font-size:10px; font-weight:700; color:#64748B; cursor:pointer; display:inline-flex; align-items:center; gap:3px; transition:all 0.15s ease;" title="Copy Note Text">
                        <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        <span>Copy</span>
                    </button>
                    <button type="button" onclick="window.DT_ORDER_VIEW.deleteNote('<?php echo $n['id']; ?>')" class="dt-note-util-btn" style="background:#FFFFFF; border:1px solid #FECACA; border-radius:4px; padding:2px 6px; font-size:10px; font-weight:700; color:#DC2626; cursor:pointer; display:inline-flex; align-items:center; gap:3px; transition:all 0.15s ease;" title="Delete Note">
                        <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        <span>Delete</span>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- ✍️ Next-Level Note Composer Section -->
        <div style="background:#FDFBF7; border:1.5px solid #D4AF37; border-radius:8px; padding:12px 14px; margin-top:4px; box-shadow:0 2px 6px rgba(212,175,55,0.1);">
            
            <!-- Category Chips Selector -->
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px; flex-wrap:wrap; gap:6px;">
                <div style="font-size:10.5px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.4px; display:flex; align-items:center; gap:4px;">
                    <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                    <span>Note Category:</span>
                </div>
                <input type="hidden" id="adminNoteSelectedTag" value="Dispatch Verification">
                <div id="adminNoteTagChips" style="display:flex; flex-wrap:wrap; gap:4px;">
                    <button type="button" onclick="window.DT_ORDER_VIEW.selectNoteTag(this, 'Dispatch Verification')" class="dt-note-tag-chip is-active" style="padding:2px 8px; font-size:10px; font-weight:800; border-radius:4px; border:1px solid #D4AF37; background:#8A681F; color:#FFFFFF; cursor:pointer; transition:all 0.15s ease;">📦 Dispatch</button>
                    <button type="button" onclick="window.DT_ORDER_VIEW.selectNoteTag(this, 'QC Audit')" class="dt-note-tag-chip" style="padding:2px 8px; font-size:10px; font-weight:700; border-radius:4px; border:1px solid #CBD5E1; background:#FFFFFF; color:#475569; cursor:pointer; transition:all 0.15s ease;">🔍 QC Check</button>
                    <button type="button" onclick="window.DT_ORDER_VIEW.selectNoteTag(this, 'Payment Verification')" class="dt-note-tag-chip" style="padding:2px 8px; font-size:10px; font-weight:700; border-radius:4px; border:1px solid #CBD5E1; background:#FFFFFF; color:#475569; cursor:pointer; transition:all 0.15s ease;">💳 Payment</button>
                    <button type="button" onclick="window.DT_ORDER_VIEW.selectNoteTag(this, 'Customer Follow-up')" class="dt-note-tag-chip" style="padding:2px 8px; font-size:10px; font-weight:700; border-radius:4px; border:1px solid #CBD5E1; background:#FFFFFF; color:#475569; cursor:pointer; transition:all 0.15s ease;">📞 Call Log</button>
                    <button type="button" onclick="window.DT_ORDER_VIEW.selectNoteTag(this, 'Urgent Attention')" class="dt-note-tag-chip" style="padding:2px 8px; font-size:10px; font-weight:700; border-radius:4px; border:1px solid #CBD5E1; background:#FFFFFF; color:#475569; cursor:pointer; transition:all 0.15s ease;">⚠️ Urgent</button>
                </div>
            </div>

            <!-- Smart Textarea -->
            <div style="position:relative; margin-bottom:8px;">
                <textarea id="newAdminNoteInput" rows="2" placeholder="Write confidential internal dispatch note, warehouse QC observation, or customer phone notes... (Ctrl + Enter to post)" onkeydown="if((event.ctrlKey || event.metaKey) && event.key === 'Enter') window.DT_ORDER_VIEW.addNote()" style="width:100%; min-height:56px; border:1.5px solid #CBD5E1; border-radius:6px; padding:8px 10px; font-family:'Plus Jakarta Sans', sans-serif; font-size:12px; line-height:1.4; color:#181512; background:#FFFFFF; box-sizing:border-box; outline:none; transition:border-color 0.15s ease, box-shadow 0.15s ease; resize:vertical;"></textarea>
            </div>

            <!-- Quick Preset Snippet Buttons -->
            <div style="display:flex; align-items:center; gap:5px; flex-wrap:wrap; margin-bottom:10px;">
                <span style="font-size:10px; font-weight:700; color:#64748B;">Quick Snippets:</span>
                <button type="button" onclick="window.DT_ORDER_VIEW.insertNoteSnippet('Manifest verified with Surat floor. Ready for dock handover.')" class="dt-snippet-btn" style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:4px; padding:2px 6px; font-size:10px; font-weight:600; color:#475569; cursor:pointer; transition:all 0.15s ease;">+ Manifest Verified</button>
                <button type="button" onclick="window.DT_ORDER_VIEW.insertNoteSnippet('Packed in heavy-duty tamper proof master carton with Silk Mark tag.')" class="dt-snippet-btn" style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:4px; padding:2px 6px; font-size:10px; font-weight:600; color:#475569; cursor:pointer; transition:all 0.15s ease;">+ Packed in Carton</button>
                <button type="button" onclick="window.DT_ORDER_VIEW.insertNoteSnippet('Payment UTR confirmed via ICICI bank portal.')" class="dt-snippet-btn" style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:4px; padding:2px 6px; font-size:10px; font-weight:600; color:#475569; cursor:pointer; transition:all 0.15s ease;">+ UTR Confirmed</button>
                <button type="button" onclick="window.DT_ORDER_VIEW.insertNoteSnippet('Buyer requested priority cargo transit delivery before Monday.')" class="dt-snippet-btn" style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:4px; padding:2px 6px; font-size:10px; font-weight:600; color:#475569; cursor:pointer; transition:all 0.15s ease;">+ Priority Transit</button>
            </div>

            <!-- Composer Actions Row -->
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; border-top:1px solid #E2DFD7; padding-top:8px;">
                <div style="display:flex; align-items:center; gap:6px; font-size:11px; color:#64748B;">
                    <div style="width:8px; height:8px; border-radius:50%; background:#16A34A;"></div>
                    <span>Posting as <strong>Gautam Sethi (Admin)</strong></span>
                </div>
                <button type="button" class="dt-btn dt-btn-gold" onclick="window.DT_ORDER_VIEW.addNote()" style="height:32px; padding:0 16px; font-size:11.5px; font-weight:800; display:inline-flex; align-items:center; gap:6px;">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                    <span>Post Admin Note</span>
                </button>
            </div>
        </div>

    </div>
</div>
