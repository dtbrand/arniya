---
description: Business Logic & Role-Based Selling Rules — 5 Roles, Single Piece vs. Full Set, Multi-variant stock
---

# 💼 DT Brand's Business Logic & Role-Based Pricing Rules

Based on [AI/BUSINESS_LOGIC.md](file:///c:/Users/sai/Desktop/WhatsApp%20CRM/AI/BUSINESS_LOGIC.md):

## 1. 5-Role Pricing Hierarchy
1. **Guest / Retail Customer**: Single Piece (customer_price ?? 
etail_price). Full Set is LOCKED.
2. **Reseller**: Single Piece (
eseller_price ?? 
etail_price). Full Set is LOCKED.
3. **Retailer**: Single Piece (
etail_price), Full Set (wholesale_price × pieces).
4. **Wholesaler**: Single Piece (wholesale_price), Full Set (wholesale_price × pieces).

## 2. Product Selling Types
- **Single Piece (single_piece)**: Individual piece purchasing across all 5 roles. Supports Customer Price and Color ➔ Size reactive swatch filtering.
- **Full Set (ull_set)**: 100% active Color × Size variants catalog bundle. Strictly restricted to verified Wholesalers & Retailers. Customer Price is disabled/nullified.

## 3. Stock Management & Decrement Engine
- Full Set order of $ sets decrements $ units from **every active variant** in product_variants and  	imes 	ext{pieces}$ from products.stock_qty.
- Single Piece order decrements $ units from the selected variant in product_variants and $ from products.stock_qty.
