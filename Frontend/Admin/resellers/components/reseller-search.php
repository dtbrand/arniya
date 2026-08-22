<?php
/**
 * reseller-search.php — Live Debounced Search, Filter Toolbar & Export Actions
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
?>

<!-- ══ SEARCH & FILTERS TOOLBAR CARD ══ -->
<div class="dt-cust-toolbar-card">
    <div class="dt-cust-search-wrap">
        <input 
            type="text" 
            id="dtResellerSearchInput" 
            class="dt-cust-search-input" 
            placeholder="Search by Reseller Name, Phone, Email, City or ID..." 
            oninput="handleResellerSearch(this)" 
            autocomplete="off"
            style="padding-left:12px;"
        >
        <button type="button" id="dtResellerSearchClearBtn" class="dt-cust-search-clear" onclick="clearResellerSearch()" title="Clear Search">✕</button>
    </div>

    <div class="dt-cust-toolbar-right">
        <!-- Sort Dropdown -->
        <select class="dt-cust-select" onchange="handleResellerSort(this)" title="Sort Reseller Records">
            <option value="newest">Sort: Newest First</option>
            <option value="name-asc">Sort: Name (A–Z)</option>
            <option value="purchase-high">Sort: Highest Lifetime GMV</option>
            <option value="orders-high">Sort: Most Orders Placed</option>
        </select>

        <!-- Advanced Filters Button -->
        <button type="button" class="dt-btn dt-btn-pale" onclick="openResellerFiltersDrawer()">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3">
                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
            </svg>
            <span>Advanced Filters</span>
        </button>

        <!-- Export Link -->
        <a href="/Frontend/Admin/resellers/export.php" class="dt-btn dt-btn-pale">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
            <span>Export Studio</span>
        </a>

        <!-- Add Reseller Button -->
        <a href="/Frontend/Admin/resellers/edit.php?action=new" class="dt-btn dt-btn-gold">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.6">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            <span>+ Add Reseller</span>
        </a>
    </div>
</div>
