<?php
/**
 * reseller-status.php — DT Brand's & Jai Hanuman Tex
 * Approval, Rejection & Credit Adjustment Modals
 */
?>

<!-- 1. Approval Modal -->
<div id="dtApproveResellerModal" class="dt-modal-backdrop">
    <div class="dt-modal-dialog">
        <div class="dt-modal-head">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#15803D" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <strong style="font-size:0.9rem; font-weight:800; color:#181512;">Approve Reseller Application</strong>
            </div>
            <button type="button" onclick="closeModal('dtApproveResellerModal')" style="background:none; border:none; color:#78716C; font-size:18px; cursor:pointer; font-weight:bold;">✕</button>
        </div>

        <form onsubmit="confirmResellerApproval(event)">
            <div class="dt-modal-body" style="display:flex; flex-direction:column; gap:12px;">
                <div style="background:#FAF8F4; padding:12px 14px; border-radius:8px; border:1px solid #EAE5D9;">
                    <div style="font-size:0.72rem; color:#78716C; font-weight:700;">APPLICANT:</div>
                    <strong id="dtApproveResellerName" style="font-size:0.95rem; color:#181512; display:block;">Shree Krishna Boutique</strong>
                    <small id="dtApproveResellerId" style="color:#8A681F; font-weight:800;">RES-1048</small>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Assign Reseller Tier *</label>
                    <select id="dtApproveTierSelect" class="dt-reseller-select" style="width:100%; height:38px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 12px; font-size:0.8rem;">
                        <option value="Silver">Silver Tier (15% Partner Margin • ₹50,000 Credit)</option>
                        <option value="Gold">Gold Tier (22% Partner Margin • ₹1,00,000 Credit)</option>
                        <option value="Platinum">Platinum Elite (30% Partner Margin • ₹1,50,000 Credit)</option>
                        <option value="Bronze">Bronze Starter (10% Partner Margin • Cash Only)</option>
                    </select>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Internal Approval Memo / Note</label>
                    <textarea class="dt-textarea-field" placeholder="Add verified GST & Aadhaar verification details..." rows="3" style="width:100%; border:1.2px solid #EAE5D9; border-radius:8px; padding:8px 12px; font-size:0.8rem; box-sizing:border-box;"></textarea>
                </div>
            </div>

            <div class="dt-modal-foot">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeModal('dtApproveResellerModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-emerald">
                    <span>✓ Confirm &amp; Activate Reseller</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Rejection Modal -->
<div id="dtRejectResellerModal" class="dt-modal-backdrop">
    <div class="dt-modal-dialog">
        <div class="dt-modal-head">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#DC2626" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                <strong style="font-size:0.9rem; font-weight:800; color:#181512;">Reject Reseller Application</strong>
            </div>
            <button type="button" onclick="closeModal('dtRejectResellerModal')" style="background:none; border:none; color:#78716C; font-size:18px; cursor:pointer; font-weight:bold;">✕</button>
        </div>

        <form onsubmit="confirmResellerRejection(event)">
            <div class="dt-modal-body" style="display:flex; flex-direction:column; gap:12px;">
                <div style="background:#FEF2F2; padding:12px 14px; border-radius:8px; border:1px solid #FECACA;">
                    <div style="font-size:0.72rem; color:#991B1B; font-weight:700;">APPLICANT:</div>
                    <strong id="dtRejectResellerName" style="font-size:0.95rem; color:#181512; display:block;">Apex Textiles</strong>
                    <small id="dtRejectResellerId" style="color:#DC2626; font-weight:800;">RES-1041</small>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Rejection Reason *</label>
                    <select id="dtRejectReasonSelect" class="dt-reseller-select" style="width:100%; height:38px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 12px; font-size:0.8rem;">
                        <option value="Incomplete Information">Incomplete Application / Contact Info</option>
                        <option value="Invalid Documents">Invalid or Unreadable KYC Documents</option>
                        <option value="Business Verification Failed">Business GSTIN / Physical Shop Verification Failed</option>
                        <option value="Duplicate Account">Duplicate Reseller Account Detected</option>
                        <option value="Not Eligible">Not Eligible for B2B Reseller Terms</option>
                        <option value="Other">Other Specific Reason</option>
                    </select>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Reason Explanation (Sent to Applicant)</label>
                    <textarea class="dt-textarea-field" placeholder="Provide clear guidance for the reseller..." rows="3" style="width:100%; border:1.2px solid #EAE5D9; border-radius:8px; padding:8px 12px; font-size:0.8rem; box-sizing:border-box;"></textarea>
                </div>
            </div>

            <div class="dt-modal-foot">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeModal('dtRejectResellerModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-rose">
                    <span>Reject Application</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 3. Credit Adjustment Modal -->
<div id="dtCreditAdjustmentModal" class="dt-modal-backdrop">
    <div class="dt-modal-dialog">
        <div class="dt-modal-head">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.5"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                <strong style="font-size:0.9rem; font-weight:800; color:#181512;">Adjust Reseller Credit / Limit</strong>
            </div>
            <button type="button" onclick="closeModal('dtCreditAdjustmentModal')" style="background:none; border:none; color:#78716C; font-size:18px; cursor:pointer; font-weight:bold;">✕</button>
        </div>

        <form onsubmit="submitCreditAdjustment(event)">
            <div class="dt-modal-body" style="display:flex; flex-direction:column; gap:12px;">
                <div style="display:flex; justify-content:space-between; background:#FAF8F4; padding:12px 14px; border-radius:8px; border:1px solid #EAE5D9;">
                    <div>
                        <div style="font-size:0.7rem; color:#78716C; font-weight:700;">CURRENT LIMIT</div>
                        <strong id="dtCreditCurrentLimit" style="font-size:1.1rem; color:#181512;">₹1,50,000</strong>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:0.7rem; color:#78716C; font-weight:700;">USED BALANCE</div>
                        <strong id="dtCreditCurrentBalance" style="font-size:1.1rem; color:#8A681F;">₹65,000</strong>
                    </div>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Adjustment Type *</label>
                    <select id="dtCreditAdjustType" class="dt-reseller-select" style="width:100%; height:38px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 12px; font-size:0.8rem;">
                        <option value="increase">Increase Credit Limit (+)</option>
                        <option value="decrease">Decrease Credit Limit (-)</option>
                        <option value="payment_settlement">Record Offline Bank Payment (Settlement)</option>
                        <option value="manual_debit">Manual Debit Charge</option>
                    </select>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Amount (₹) *</label>
                    <input type="number" id="dtCreditAdjustAmount" class="dt-input-field" placeholder="e.g. 25000" min="1" required style="width:100%; height:38px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 12px; font-size:0.85rem; font-weight:700; box-sizing:border-box;">
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Reason &amp; Audit Memo *</label>
                    <input type="text" id="dtCreditAdjustReason" class="dt-input-field" placeholder="e.g. Festive season seasonal limit hike / Cheque #88412 deposited" required style="width:100%; height:38px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 12px; font-size:0.8rem; box-sizing:border-box;">
                </div>
            </div>

            <div class="dt-modal-foot">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeModal('dtCreditAdjustmentModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">
                    <span>Submit Credit Entry</span>
                </button>
            </div>
        </form>
    </div>
</div>
