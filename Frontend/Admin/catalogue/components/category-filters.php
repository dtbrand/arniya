<?php
/**
 * category-filters.php — Catalogue Filter Toolbar Component
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="wp-tablenav" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; margin-bottom:12px;">
    <div class="wp-tablenav-actions" style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
        <select class="wp-select" id="catBulkActionSelect" style="height:28px; font-size:11.5px; padding:0 6px; border-radius:4px; border:1px solid #c3c4c7;">
            <option value="">Bulk actions</option>
            <option value="activate">Activate Selected</option>
            <option value="deactivate">Deactivate Selected</option>
            <option value="feature">Mark as Featured</option>
            <option value="delete">Delete Selected</option>
        </select>
        <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_CATALOGUE.applyBulkAction('catBulkActionSelect', 'cat-row-chk')" style="height:28px; font-size:11px; padding:0 10px;">
            <span>Apply</span>
        </button>

        <select class="wp-select" id="catStatusFilter" onchange="if(window.DT_FILTERS) window.DT_FILTERS.applyStatusFilter(this.value)" style="height:28px; font-size:11.5px; padding:0 6px; border-radius:4px; border:1px solid #c3c4c7;">
            <option value="">Filter by status</option>
            <option value="active">Active (14)</option>
            <option value="inactive">Inactive (2)</option>
        </select>
    </div>

    <!-- Real-time Search Box with Left-Aligned Icon -->
    <div style="display:flex; align-items:center; gap:6px;">
        <div style="position:relative; display:inline-flex; align-items:center;">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2.2" style="position:absolute; left:8px; pointer-events:none;">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" id="catSearchInput" placeholder="Search categories, slugs..." style="height:28px; padding-left:26px; padding-right:22px; width:190px; font-size:11.5px; border:1px solid #c3c4c7; border-radius:4px; outline:none;" oninput="window.DT_CATALOGUE.filterTable('catSearchInput', 'catListTable', 'catSearchClear')">
            <span id="catSearchClear" onclick="window.DT_CATALOGUE.clearSearch('catSearchInput', 'catListTable', 'catSearchClear')" style="position:absolute; right:7px; cursor:pointer; color:#8c8f94; font-size:12px; font-weight:700; display:none;" title="Clear search">✕</span>
        </div>
        <button type="button" class="dt-btn-action-sm gold" onclick="window.DT_CATALOGUE.filterTable('catSearchInput', 'catListTable')" style="height:28px; font-size:11px; padding:0 10px;">
            <span>Search</span>
        </button>
    </div>
</div>
