<?php
/**
 * retail-search.php — DT Brand's & Jai Hanuman Tex
 * Universal Debounced Retail Search Bar
 */
?>

<div style="position:relative; width:100%; max-width:320px;">
    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#78716C" stroke-width="2.2" style="position:absolute; left:10px; top:50%; transform:translateY(-50%); pointer-events:none;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
    <input type="text" class="dt-retail-input" style="width:100%; height:32px; padding-left:30px; font-size:0.75rem; border-radius:6px; border:1.2px solid #EAE5D9; box-sizing:border-box;" placeholder="Universal search (SKU, Customer, Order)..." oninput="if(typeof filterRetailOrders==='function') filterRetailOrders(); if(typeof filterRetailCustomers==='function') filterRetailCustomers();">
</div>
