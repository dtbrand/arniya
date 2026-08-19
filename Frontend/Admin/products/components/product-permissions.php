<?php
/**
 * product-permissions.php — Multi-Channel Visibility & Tier Permissions
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head" style="display:flex; align-items:center; justify-content:space-between;">
        <h3 class="dt-form-sec-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            <span>Channel Permissions</span>
        </h3>
        <button type="button" class="wp-page-title-action secondary" style="font-size:11px; padding:1px 6px;" onclick="toggleAllChannelPermissions(this)">Select All</button>
    </div>
    <div class="dt-form-sec-body">
        <div style="display:flex; flex-direction:column; gap:9px;" id="dtChannelPermList">
            <!-- 1. Customers -->
            <label style="display:flex; align-items:center; justify-content:space-between; font-size:12.5px; font-weight:600; cursor:pointer; padding:6px 8px; border:1px solid #e5e1d7; border-radius:4px; background:#fff; transition:all 0.12s ease;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <input type="checkbox" class="dt-channel-perm-cb" checked>
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#2563EB" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <span>Customers</span>
                </div>
                <span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-size:10.5px; padding:1px 6px;">Direct B2C</span>
            </label>

            <!-- 2. Resellers -->
            <label style="display:flex; align-items:center; justify-content:space-between; font-size:12.5px; font-weight:600; cursor:pointer; padding:6px 8px; border:1px solid #e5e1d7; border-radius:4px; background:#fff; transition:all 0.12s ease;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <input type="checkbox" class="dt-channel-perm-cb" checked>
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor" style="color:#25D366;"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                    <span>Resellers</span>
                </div>
                <span class="adm-badge" style="background:#F0FDF4; color:#15803D; font-size:10.5px; padding:1px 6px;">WhatsApp B2B</span>
            </label>

            <!-- 3. Retailers -->
            <label style="display:flex; align-items:center; justify-content:space-between; font-size:12.5px; font-weight:600; cursor:pointer; padding:6px 8px; border:1px solid #e5e1d7; border-radius:4px; background:#fff; transition:all 0.12s ease;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <input type="checkbox" class="dt-channel-perm-cb" checked>
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#7E22CE" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    <span>Retailers</span>
                </div>
                <span class="adm-badge" style="background:#FAF5FF; color:#7E22CE; font-size:10.5px; padding:1px 6px;">Shop Owners</span>
            </label>

            <!-- 4. Wholesalers -->
            <label style="display:flex; align-items:center; justify-content:space-between; font-size:12.5px; font-weight:600; cursor:pointer; padding:6px 8px; border:1px solid #e5e1d7; border-radius:4px; background:#fff; transition:all 0.12s ease;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <input type="checkbox" class="dt-channel-perm-cb" checked>
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2"><rect x="1" y="3" width="22" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                    <span>Wholesalers</span>
                </div>
                <span class="adm-badge gold" style="font-size:10.5px; padding:1px 6px;">Bulk Mill Lots</span>
            </label>
        </div>
    </div>
</div>

<script>
function toggleAllChannelPermissions(btn) {
    const cbs = document.querySelectorAll('.dt-channel-perm-cb');
    const anyUnchecked = Array.from(cbs).some(cb => !cb.checked);
    cbs.forEach(cb => cb.checked = anyUnchecked);
    btn.textContent = anyUnchecked ? 'Deselect All' : 'Select All';
    if (typeof window.showToast === 'function') {
        window.showToast(anyUnchecked ? '✨ All channels enabled' : 'Channel permissions cleared');
    }
}
</script>
