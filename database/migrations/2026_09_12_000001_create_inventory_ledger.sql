-- ==============================================================================
-- DT BRAND'S & JAI HANUMAN TEX — INVENTORY LEDGER & STOCK MOVEMENTS MIGRATION
-- Migration: 2026_09_12_000001_create_inventory_ledger.sql
-- Master Wholesale Architecture: Audited Stock Inward, Outward & Adjustments
-- ==============================================================================

CREATE TABLE IF NOT EXISTS `inventory_ledger` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `product_id` INT NOT NULL,
    `variant_id` INT NULL DEFAULT NULL,
    `sku` VARCHAR(100) NULL,
    `movement_type` ENUM('inward', 'outward', 'adjustment', 'order_deduction', 'order_cancellation', 'audit') NOT NULL DEFAULT 'adjustment',
    `previous_qty` INT NOT NULL DEFAULT 0,
    `adjustment_qty` INT NOT NULL DEFAULT 0,
    `new_qty` INT NOT NULL DEFAULT 0,
    `reason` VARCHAR(255) NULL,
    `reference_id` VARCHAR(100) NULL,
    `operator` VARCHAR(100) NULL DEFAULT 'Admin',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_inv_product` (`product_id`),
    INDEX `idx_inv_variant` (`variant_id`),
    INDEX `idx_inv_movement` (`movement_type`),
    INDEX `idx_inv_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
