<?php
/**
 * reseller-search.php — DT Brand's & Jai Hanuman Tex
 * Reseller Toolbar with Debounced Search, Clear Button & Action Triggers
 */
?>

<div class="dt-reseller-toolbar">
    <!-- Search Bar -->
    <div class="dt-reseller-search-wrap">
        <div style="position:relative; flex:1; display:flex; align-items:center;">
            <input type="text" 
                   id="dtResellerSearchInput" 
                   class="dt-input-field" 
                   placeholder="Search by Reseller Name, ID, Contact, Phone, City, GSTIN..." 
                   oninput="handleResellerSearch(this)"
                   style="width:100%; height:38px; padding:0 36px 0 14px; font-size:0.82rem; font-weight:600; border:1.2px solid #EAE5D9; border-radius:8px; background:#FFFFFF;">
            
            <button type="button" 
                    id="dtResellerSearchClearBtn" 
                    onclick="clearResellerSearch()"
                    style="display:none; position:absolute; right:10px; width:20px; height:20px; border-radius:50%; background:#EAE5D9; border:none; color:#181512; font-size:11px; font-weight:bold; align-items:center; justify-content:center; cursor:pointer;"
                    title="Clear search">✕</button>
        </div>

        <button type="button" class="dt-btn dt-btn-pale" onclick="handleResellerSearch(document.getElementById('dtResellerSearchInput'))" style="height:38px; padding:0 14px;">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#705114" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <span>Search</span>
        </button>
    </div>

    <!-- Right Controls -->
    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
        <!-- Sorting -->
        <select class="dt-reseller-select" onchange="handleResellerSort(this)" style="height:38px; padding:0 12px; font-size:0.78rem; font-weight:700; border:1.2px solid #EAE5D9; border-radius:8px; background:#FFFFFF; color:#181512;">
            <option value="newest">Sort: Newest First</option>
            <option value="oldest">Sort: Oldest First</option>
            <option value="purchase-high">Sort: Highest GMV</option>
            <option value="purchase-low">Sort: Lowest GMV</option>
            <option value="orders-high">Sort: Most Orders</option>
            <option value="name-asc">Sort: Name (A-Z)</option>
            <option value="name-desc">Sort: Name (Z-A)</option>
        </select>

        <!-- Advanced Filter -->
        <button type="button" class="dt-btn dt-btn-pale" onclick="openResellerFiltersDrawer()" style="height:38px;">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#705114" stroke-width="2.5"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
            <span>Filters</span>
        </button>

        <!-- Export -->
        <a href="/Frontend/Admin/resellers/export.php" class="dt-btn dt-btn-pale" style="height:38px;">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#705114" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            <span>Export</span>
        </a>

        <!-- Add Reseller -->
        <a href="/Frontend/Admin/resellers/edit.php?action=new" class="dt-btn dt-btn-gold" style="height:38px;">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            <span>+ Add Reseller</span>
        </a>
    </div>
</div>
