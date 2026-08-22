<?php
/**
 * wholesale-search.php — DT Brand's & Jai Hanuman Tex
 * Debounced Search Bar & Quick Filters Component
 */
?>
<div style="padding:10px 18px; border-bottom:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; background:#FFFFFF;">
    <!-- Live Search Box with Icon -->
    <div style="position:relative; flex:1; min-width:240px; max-width:380px;">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#78716C" stroke-width="2.2" style="position:absolute; left:10px; top:50%; transform:translateY(-50%); pointer-events:none;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        <input type="text" id="wholesaleSearchInput" class="dt-wholesale-input" style="width:100%; height:34px; padding-left:32px; font-size:0.75rem; border:1.2px solid #EAE5D9; border-radius:8px; box-sizing:border-box;" placeholder="Search Wholesale ID, Business, Contact..." oninput="filterWholesaleTable()">
    </div>

    <!-- Quick Dropdown Filters -->
    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
        <select id="wholesaleTierFilter" class="dt-wholesale-select" style="height:34px; font-size:0.75rem; padding:0 8px; border-radius:8px; border:1.2px solid #EAE5D9;" onchange="filterWholesaleTable()">
            <option value="all">All Wholesale Tiers</option>
            <option value="platinum wholesale">Platinum Wholesale (35%)</option>
            <option value="gold distributor">Gold Distributor (28%)</option>
            <option value="silver bulk partner">Silver Bulk Partner (20%)</option>
            <option value="bronze starter">Bronze Starter (12%)</option>
        </select>

        <select id="wholesaleStatusFilter" class="dt-wholesale-select" style="height:34px; font-size:0.75rem; padding:0 8px; border-radius:8px; border:1.2px solid #EAE5D9;" onchange="filterWholesaleTable()">
            <option value="all">All Statuses</option>
            <option value="approved">Active / Approved</option>
            <option value="pending">Pending Review</option>
            <option value="suspended">Suspended / Locked</option>
        </select>

        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="clearWholesaleSearch()">
            <span>Reset</span>
        </button>
    </div>
</div>
