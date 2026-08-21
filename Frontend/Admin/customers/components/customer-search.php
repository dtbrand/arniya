<?php
/**
 * customer-search.php — Live Debounced Search, Filter Toolbar & Export Actions
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
?>

<!-- ══ SEARCH & FILTERS TOOLBAR CARD ══ -->
<div class="dt-cust-toolbar-card">
    <div class="dt-cust-search-wrap">
        <svg class="dt-cust-search-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
        <input 
            type="text" 
            id="dtCustSearchInput" 
            class="dt-cust-search-input" 
            placeholder="Search by Customer Name, Phone, Email, City or ID..." 
            oninput="handleCustomerSearch(this.value)" 
            autocomplete="off"
        >
        <button type="button" id="dtCustSearchClear" class="dt-cust-search-clear" onclick="clearCustomerSearch()" title="Clear Search">✕</button>
    </div>

    <div class="dt-cust-toolbar-right">
        <!-- Sort Dropdown -->
        <select class="dt-cust-select" onchange="sortCustomersBy(this.value)" title="Sort Customer Records">
            <option value="id">Sort: Newest First</option>
            <option value="name">Sort: Name (A–Z)</option>
            <option value="spent">Sort: Highest Lifetime Spend</option>
            <option value="orders">Sort: Most Orders Placed</option>
        </select>

        <!-- Advanced Filters Button -->
        <button type="button" class="dt-btn dt-btn-pale" onclick="openCustomerFiltersModal()">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3">
                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
            </svg>
            <span>Advanced Filters</span>
        </button>

        <!-- Export Link -->
        <a href="/Frontend/Admin/customers/export.php" class="dt-btn dt-btn-pale">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
            <span>Export Studio</span>
        </a>

        <!-- Add Customer Button -->
        <a href="/Frontend/Admin/customers/new.php" class="dt-btn dt-btn-gold">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.6">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            <span>Add Customer</span>
        </a>
    </div>
</div>
