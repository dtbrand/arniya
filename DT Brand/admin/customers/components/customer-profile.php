<?php
/**
 * customer-profile.php — Customer 360° Identity Card & Contact Tools
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
$customer_id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : 'CUST-1042';
?>

<!-- ══ CUSTOMER IDENTITY CARD (LEFT DOSSIER COLUMN) ══ -->
<div class="dt-cust-sidebar-card">
    <div class="dt-cust-dossier-hero">
        <div class="dt-cust-dossier-avatar">PS</div>
        <div>
            <h2 class="dt-cust-dossier-name">Pooja Sharma</h2>
            <div class="dt-cust-dossier-meta">
                <span class="dt-status-pill active" style="font-size:0.65rem;">● Active Verified</span>
                <span class="dt-status-pill vip" style="font-size:0.65rem;">★ VIP Customer</span>
            </div>
            <span class="dt-cust-id-badge" style="display:block; margin-top:4px;">#<?php echo $customer_id; ?> • Registered Jan 12, 2025</span>
        </div>
    </div>

    <!-- Contact & Direct Communication Tools -->
    <div class="dt-cust-contact-actions">
        <div class="dt-cust-contact-item">
            <span class="dt-cust-contact-val">+91 98110 29381</span>
            <div style="display:flex; gap:4px;">
                <button type="button" class="dt-cust-contact-btn" onclick="copyToClipboard('+919811029381', 'Phone Number')">Copy</button>
                <a href="tel:+919811029381" class="dt-cust-contact-btn">Call</a>
            </div>
        </div>

        <div class="dt-cust-contact-item">
            <span class="dt-cust-contact-val">pooja.sharma92@gmail.com</span>
            <div style="display:flex; gap:4px;">
                <button type="button" class="dt-cust-contact-btn" onclick="copyToClipboard('pooja.sharma92@gmail.com', 'Email')">Copy</button>
                <a href="mailto:pooja.sharma92@gmail.com" class="dt-cust-contact-btn">Email</a>
            </div>
        </div>

        <a href="https://wa.me/919811029381?text=Hello%20Pooja%2C%20welcome%20to%20DT%20Brand%27s" target="_blank" class="dt-btn dt-btn-emerald" style="width:100%;">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#FFFFFF" stroke-width="2.3">
                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
            </svg>
            <span>1-Click WhatsApp Connect</span>
        </a>
    </div>

    <!-- Quick Action Pills -->
    <div style="display:flex; flex-direction:column; gap:6px;">
        <a href="/DT%20Brand/admin/customers/edit.php?id=<?php echo $customer_id; ?>" class="dt-btn dt-btn-pale" style="width:100%;">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            <span>Edit Profile Details</span>
        </a>
        <button type="button" class="dt-btn dt-btn-pale" style="width:100%;" onclick="openCustomerStatusModal('<?php echo $customer_id; ?>', 'active')">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            <span>Adjust Account Standing</span>
        </button>
        <button type="button" class="dt-btn dt-btn-pale" style="width:100%;" onclick="triggerPasswordResetEmail('pooja.sharma92@gmail.com')">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            <span>Send Password Reset Email</span>
        </button>
    </div>

    <!-- Customer Tags Box -->
    <div>
        <div style="font-size:0.72rem; font-weight:800; color:#78716C; text-transform:uppercase; margin-bottom:8px;">Assigned Tags</div>
        <div class="dt-cust-tags-wrap" id="dtCustTagsContainer">
            <span class="dt-cust-tag-chip gold"><span>VIP High-Value</span></span>
            <span class="dt-cust-tag-chip purple"><span>Saree Enthusiast</span></span>
            <span class="dt-cust-tag-chip green"><span>Frequent Buyer</span></span>
        </div>
    </div>
</div>
