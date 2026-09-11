-- ============================================================================
-- Migration: 2026_09_12_000009_create_returns_and_reports_tables.sql
-- Description: Create order_returns table and seed sample data for Section 33 Reports Suite
-- DT Brand's & Jai Hanuman Tex — Master Wholesale Architecture
-- ============================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- 1. ORDER RETURNS TABLE
CREATE TABLE IF NOT EXISTS `order_returns` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `return_number` VARCHAR(50) NOT NULL UNIQUE,
    `order_id` INT NOT NULL,
    `order_number` VARCHAR(50) NOT NULL,
    `customer_id` INT DEFAULT NULL,
    `customer_name` VARCHAR(150) NOT NULL,
    `customer_phone` VARCHAR(20) DEFAULT NULL,
    `return_type` ENUM('refund', 'replacement', 'store_credit') NOT NULL DEFAULT 'refund',
    `reason` ENUM('fabric_defect', 'size_misfit', 'color_variation', 'wrong_item', 'damaged_in_transit', 'customer_cancelled') NOT NULL DEFAULT 'fabric_defect',
    `reason_details` TEXT DEFAULT NULL,
    `status` ENUM('requested', 'approved', 'pickup_scheduled', 'received', 'inspected', 'refunded', 'replaced', 'rejected') NOT NULL DEFAULT 'requested',
    `items_count` INT NOT NULL DEFAULT 1,
    `refund_amount` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `awb_number` VARCHAR(50) DEFAULT NULL,
    `courier_partner` VARCHAR(50) DEFAULT 'Delhivery Express',
    `admin_notes` TEXT DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_ret_order` (`order_id`),
    INDEX `idx_ret_customer` (`customer_id`),
    INDEX `idx_ret_status` (`status`),
    INDEX `idx_ret_reason` (`reason`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. SEED REALISTIC SAMPLE DATA (IF EMPTY)
INSERT IGNORE INTO `order_returns` 
(`id`, `return_number`, `order_id`, `order_number`, `customer_name`, `customer_phone`, `return_type`, `reason`, `reason_details`, `status`, `items_count`, `refund_amount`, `awb_number`, `courier_partner`, `admin_notes`, `created_at`) 
VALUES
(1, 'RET-2026-001', 1, 'DTB-1001', 'Pooja Sharma', '+91 98251 44520', 'refund', 'fabric_defect', 'Minor zari thread snagging on pallu edge', 'refunded', 1, 2450.00, 'DLHV-RET-88192', 'Delhivery Express', 'Returned item inspected at Surat depot. Full refund issued via UPI.', DATE_SUB(NOW(), INTERVAL 12 DAY)),
(2, 'RET-2026-002', 2, 'DTB-1002', 'Vandana Vastra Niketan', '+91 94140 33219', 'replacement', 'size_misfit', 'Kurti set size 40 required instead of 38', 'replaced', 2, 3800.00, 'BD-RET-11029', 'BlueDart Air Cargo', 'Replacement dispatch dispatched via BlueDart under AWB BD-99120.', DATE_SUB(NOW(), INTERVAL 8 DAY)),
(3, 'RET-2026-003', 3, 'DTB-1003', 'Meera Patel', '+91 98790 12345', 'refund', 'color_variation', 'Shade slightly brighter than mobile catalog photo', 'inspected', 1, 1850.00, 'DLHV-RET-90123', 'Delhivery Express', 'Received at warehouse, refund pending approval.', DATE_SUB(NOW(), INTERVAL 3 DAY)),
(4, 'RET-2026-004', 4, 'DTB-1004', 'Kavita Boutique', '+91 98980 99887', 'store_credit', 'damaged_in_transit', 'Outer carton crushed, moisture marks on plastic sleeve', 'approved', 3, 5600.00, 'TCI-RET-44019', 'TCI Freight', 'Store credit voucher CR-5600 issued for next wholesale lot order.', DATE_SUB(NOW(), INTERVAL 1 DAY));

SET FOREIGN_KEY_CHECKS = 1;
