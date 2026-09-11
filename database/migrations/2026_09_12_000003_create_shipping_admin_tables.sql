-- ============================================================================
-- Migration: 2026_09_12_000003_create_shipping_admin_tables.sql
-- Section 27: Shipping Admin Architecture & Logistics Suite
-- DT Brand's & Jai Hanuman Tex — Surat Logistics Depot
-- ============================================================================

-- 1. Shipping Geographic Zones Table
CREATE TABLE IF NOT EXISTS `shipping_zones` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `zone_code` VARCHAR(50) NOT NULL UNIQUE,
    `zone_name` VARCHAR(150) NOT NULL,
    `state_names` TEXT NULL COMMENT 'Comma-separated state names mapped to this zone',
    `city_names` TEXT NULL COMMENT 'Key cities or hubs mapped to this zone',
    `pincode_prefixes` VARCHAR(255) NULL COMMENT 'Comma-separated 2-digit pincode prefixes',
    `base_rate` DECIMAL(10,2) NOT NULL DEFAULT 40.00,
    `per_unit_rate` DECIMAL(10,2) NOT NULL DEFAULT 20.00,
    `free_threshold` DECIMAL(10,2) NOT NULL DEFAULT 999.00,
    `sla` VARCHAR(100) NOT NULL DEFAULT '24–48 Hours',
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_zone_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Carrier Integrations Metadata Table (Zero Plain Secrets Stored Here)
CREATE TABLE IF NOT EXISTS `shipping_carriers` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `carrier_code` VARCHAR(50) NOT NULL UNIQUE,
    `carrier_name` VARCHAR(100) NOT NULL,
    `carrier_type` VARCHAR(50) NOT NULL DEFAULT 'express' COMMENT 'express, air, surface, b2b_cargo',
    `api_endpoint` VARCHAR(255) NOT NULL,
    `sla_description` VARCHAR(150) NULL,
    `is_active` TINYINT(1) DEFAULT 1,
    `is_configured` TINYINT(1) DEFAULT 0,
    `last_successful_call` DATETIME NULL,
    `last_error` VARCHAR(255) NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_carrier_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Shipping Delivery Exceptions & NDR Table
CREATE TABLE IF NOT EXISTS `shipping_exceptions` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT NULL,
    `order_number` VARCHAR(50) NOT NULL,
    `awb_number` VARCHAR(100) NOT NULL,
    `carrier` VARCHAR(50) NOT NULL DEFAULT 'Delhivery Express',
    `exception_type` ENUM('NDR', 'RTO_INITIATED', 'ADDRESS_INCOMPLETE', 'CUSTOMER_UNAVAILABLE', 'REFUSED_DELIVERY', 'PINCODE_UNSERVICEABLE') NOT NULL DEFAULT 'NDR',
    `exception_reason` VARCHAR(255) NOT NULL,
    `status` ENUM('PENDING', 'RE_ATTEMPT_SCHEDULED', 'RTO_IN_TRANSIT', 'RTO_DELIVERED', 'RESOLVED') NOT NULL DEFAULT 'PENDING',
    `attempts_count` INT NOT NULL DEFAULT 1,
    `customer_name` VARCHAR(150) NULL,
    `customer_phone` VARCHAR(25) NULL,
    `shipping_city` VARCHAR(100) NULL,
    `reported_at` DATETIME NOT NULL,
    `resolved_at` DATETIME NULL,
    `resolution_notes` TEXT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_exc_awb` (`awb_number`),
    INDEX `idx_exc_order` (`order_number`),
    INDEX `idx_exc_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Shipping Audit Logs Table
CREATE TABLE IF NOT EXISTS `shipping_audit_logs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `event_type` VARCHAR(50) NOT NULL COMMENT 'RATE_UPDATE, CARRIER_TEST, LABEL_PRINT, EXCEPTION_RESOLVE, ZONE_UPDATE',
    `carrier` VARCHAR(50) NULL,
    `awb_number` VARCHAR(100) NULL,
    `order_number` VARCHAR(50) NULL,
    `admin_user` VARCHAR(100) NOT NULL DEFAULT 'System Admin',
    `ip_address` VARCHAR(45) NULL,
    `details` TEXT NULL,
    `status_code` INT DEFAULT 200,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_audit_event` (`event_type`),
    INDEX `idx_audit_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Seed Initial Default Zones if Table is Empty
INSERT IGNORE INTO `shipping_zones` (`zone_code`, `zone_name`, `state_names`, `city_names`, `pincode_prefixes`, `base_rate`, `per_unit_rate`, `free_threshold`, `sla`, `is_active`) VALUES
('zone_a', 'Zone A — Gujarat Intra-State & Surat Depot', 'Gujarat, Daman & Diu, Dadra & Nagar Haveli', 'Surat, Ahmedabad, Vadodara, Rajkot, Bhavnagar', '36,37,38,39', 40.00, 20.00, 999.00, '24–48 Hours', 1),
('zone_b', 'Zone B — Tier-1 Metro Corridor', 'Maharashtra, Delhi, Karnataka, Telangana, Tamil Nadu, West Bengal', 'Mumbai, Delhi NCR, Bengaluru, Hyderabad, Chennai, Kolkata', '11,12,13,40,41,42,43,44,50,56,60,70', 60.00, 30.00, 1499.00, '2–3 Days', 1),
('zone_c', 'Zone C — Rest of India (Air / Express Surface)', 'Rajasthan, Madhya Pradesh, Uttar Pradesh, Punjab, Haryana, Kerala, Odisha, Bihar', 'Jaipur, Indore, Lucknow, Chandigarh, Kochi, Bhubaneswar, Patna', '14,15,16,17,20,21,22,23,24,25,26,27,28,30,31,32,33,34,45,46,47,48,49,67,68,69,75,76,77,80,81,82,83,84,85', 80.00, 40.00, 1999.00, '3–5 Days', 1),
('zone_d', 'Zone D — Special Regions & Hill Tracts', 'Assam, Meghalaya, Manipur, Mizoram, Nagaland, Tripura, Arunachal Pradesh, Jammu & Kashmir, Ladakh', 'Guwahati, Shillong, Imphal, Srinagar, Jammu, Leh', '18,19,78,79', 120.00, 60.00, 2999.00, '5–7 Days', 1),
('wholesale_b2b', 'Wholesale Master B2B Bales (>20 kg)', 'All India Freight Transport Hubs', 'All Major Commercial Mill Corridors via TCI Freight / V-Trans', 'ALL', 18.00, 18.00, 25000.00, '3–6 Days Regional', 1);

-- 6. Seed Initial Logistics Carriers
INSERT IGNORE INTO `shipping_carriers` (`carrier_code`, `carrier_name`, `carrier_type`, `api_endpoint`, `sla_description`, `is_active`, `is_configured`, `last_successful_call`) VALUES
('delhivery', 'Delhivery Express Surface & Air', 'express', 'https://track.delhivery.com/api/v1/', '19,000+ Pincodes | SLA: 2–4 Business Days | Full COD & Prepaid', 1, 1, NOW()),
('bluedart', 'BlueDart Air Express (Priority)', 'air', 'https://api.bluedart.com/servlet/RoutingServlet', 'Overnight Metro Air SLA: 24–48 Hours | High Security Bridal Ware', 1, 1, NOW()),
('tci', 'TCI Freight B2B Cargo Logistics', 'b2b_cargo', 'https://tcil.com/tcil/tracking.html', 'Surface Transport for Master Bales >20kg | SLA: 3–6 Days Regional', 1, 1, NOW()),
('dtdc', 'DTDC Express Regional Logistics', 'surface', 'https://tracking.dtdc.com/ct/track', 'Extensive Tier-2/3 Reach | SLA: 2–5 Days Domestic Pincodes', 1, 1, NOW());
