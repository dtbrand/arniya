-- ==============================================================================
-- DT BRAND'S & JAI HANUMAN TEX — PRODUCTION DATABASE SEEDERS
-- ==============================================================================

-- Seed Categories
INSERT INTO `categories` (`name`, `slug`, `description`, `image`, `display_order`, `status`, `products_count`)
VALUES 
('Kanjivaram Silk', 'kanjivaram-silk', 'Authentic handwoven Kanjivaram silk sarees with tested gold zari.', '/assets/images/product1.png', 1, 'active', 120),
('Banarasi Silk', 'banarasi-silk', 'Varanasi handloom kadwa meenakari pure katan silk sarees.', '/assets/images/product2.png', 2, 'active', 85),
('Paithani', 'paithani', 'Yeola handloom pure silk sarees with traditional peacock pallu.', '/assets/images/product3.png', 3, 'active', 45),
('Designer Kurtis', 'designer-kurtis', 'Chanderi silk and georgette Anarkali kurti sets with embroidery.', '/assets/images/product5.png', 4, 'active', 94),
('Organza Sarees', 'organza-sarees', 'Lightweight pure glass organza sarees with scalloped borders.', '/assets/images/product4.png', 5, 'active', 62),
('Georgette & Chiffon', 'georgette-chiffon', 'Pure 60-gram georgette sarees with Bandhej dots and gota patti.', '/assets/images/product8.png', 6, 'active', 48),
('Cotton', 'cotton', 'Airy Bagru hand block printed pure mulmul cotton sarees.', '/assets/images/product7.png', 7, 'active', 60),
('Saree', 'saree', 'Bridal velvet and raw silk couture lehengas with zardozi embroidery.', '/assets/images/product6.png', 8, 'active', 35)
ON DUPLICATE KEY UPDATE name=VALUES(name), description=VALUES(description), image=VALUES(image);

-- Seed Products
INSERT INTO `products` (
    `sku`, `title`, `slug`, `category_name`, `fabric`, `weave`, `zari_type`, `pallu_style`, 
    `blouse_piece`, `occasion`, `mrp`, `retail_price`, `wholesale_price`, `reseller_price`, 
    `moq_single`, `moq_half_set`, `moq_full_set`, `moq_master_bale`, `stock_qty`, 
    `rating`, `reviews_count`, `primary_image`, `badge`, `status`, `description`
) VALUES 
('KLN-SR-111', 'Nilambari Silk Saree with Rich Zari Pallu', 'nilambari-silk-saree-rich-zari-pallu', 'Kanjivaram Silk', 'Pure Mulberry Silk', 'Handloom Korvai Weave', 'Tested Gold Zari', 'Rich Temple Brocade Pallu', 'Running Blouse with Zari Border', 'Bridal & Festive', 6500.00, 4899.00, 1399.00, 2100.00, 1, 4, 8, 24, 95, 4.9, 142, '/assets/images/product1.png', 'Bestseller', 'in_stock', 'Authentic handwoven Kanjivaram pure silk saree featuring pure tested gold zari pallu and contrast korvai border.'),
('BNR-SR-204', 'Royal Banarasi Meenakari Silk Saree', 'royal-banarasi-meenakari-silk-saree', 'Banarasi Silk', 'Katan Brocade Silk', 'Varanasi Kadwa Weave', 'Antique Gold & Silver Zari', 'Intricate Floral Meenakari Pallu', 'Contrast Embroidered Blouse (0.8m)', 'Royal Wedding & Reception', 11000.00, 8499.00, 2499.00, 3800.00, 1, 4, 8, 24, 60, 4.9, 218, '/assets/images/product2.png', 'Exclusive', 'in_stock', 'Royal Banarasi pure silk saree with handcrafted kadwa meenakari motifs and rich gold zari weave.'),
('PTH-SR-308', 'Maharani Paithani Pure Silk Saree', 'maharani-paithani-pure-silk-saree', 'Paithani', 'Fine Mulberry Silk', 'Yeola Handloom Weave', 'Pure Muga Gold Zari', 'Signature Mor & Asawali Peacock Pallu', 'Matching Silk Blouse Piece', 'Traditional Festive & Wedding', 16500.00, 12999.00, 3999.00, 5800.00, 1, 4, 8, 24, 40, 5.0, 96, '/assets/images/product3.png', 'Heritage', 'in_stock', 'Authentic Yeola Paithani pure silk saree with traditional peacock motif pallu and rich zari border.'),
('DKR-KT-412', 'Surat Designer Embroidered Anarkali Kurti', 'surat-designer-embroidered-anarkali-kurti', 'Designer Kurtis', 'Pure Chanderi Silk & Mulmul Lining', 'Machine & Hand Zardozi Embroidery', 'Gota Patti & Sequin Work', 'Heavy Flared Hemline with Organza Dupatta', 'Stitched Kurti with Pant & Dupatta Set', 'Partywear & Festive', 3999.00, 2899.00, 850.00, 1250.00, 1, 4, 8, 24, 110, 4.8, 164, '/assets/images/product5.png', 'Trending', 'in_stock', 'Designer 3-piece Chanderi silk Anarkali Kurti set with intricate gota patti and sequin work.'),
('ORG-SR-515', 'Pastel Organza Scallop Embroidered Saree', 'pastel-organza-scallop-embroidered-saree', 'Organza Sarees', 'Pure Glass Organza Silk', 'Computerised & Hand Scalloped Embroidery', 'Micro Sequin & Cut-Dana Zari', 'Scalloped Cutwork Fancy Pallu', 'Heavy Designer Net/Silk Blouse (0.8m)', 'Cocktail, Farewell & Reception', 5500.00, 3999.00, 1199.00, 1750.00, 1, 4, 8, 24, 75, 4.7, 88, '/assets/images/product4.png', 'New Arrival', 'in_stock', 'Lightweight pure glass organza saree featuring delicate floral cutwork and scalloped gold borders.'),
('GGT-SR-620', 'Surat Viscose Georgette Bandhani Saree', 'surat-viscose-georgette-bandhani-saree', 'Georgette & Chiffon', 'Pure 60-Gram Viscose Georgette', 'Kutch Traditional Hand Bandhej & Gota Patti', 'Fine Real Zari Gota Border', 'Rich Heavy Gota Jaal Pallu with Latkan', 'Raw Silk Blouse with Gota Sleeve Work', 'Haldi, Mehendi & Family Functions', 4800.00, 3499.00, 1050.00, 1550.00, 1, 4, 8, 24, 85, 4.9, 105, '/assets/images/product8.png', 'Hot Seller', 'in_stock', 'Pure 60-gram georgette saree crafted with authentic Bandhej dots and shimmering hand-stitched gota patti.'),
('KN-SAR-007', 'Mustard Hand Block Print Mulmul Saree', 'mustard-hand-block-print-mulmul-saree', 'Cotton', '100% Breathable Mulmul Cotton', 'Bagru Dabu Hand Block Printed', 'Zari Weft Temple Border', 'Geometric Artisanal Block Print Pallu with Tassels', 'Printed Mulmul Cotton Blouse Piece', 'Daily Wear, Office & Summer Festive', 2600.00, 1899.00, 599.00, 899.00, 1, 4, 8, 24, 130, 4.6, 56, '/assets/images/product7.png', 'Summer Edit', 'in_stock', 'Airy hand block printed pure mulmul cotton saree using natural vegetable dyes for all-day comfort.'),
('KN-LEH-006', 'Velvet Zardozi Bridal Couture Lehenga', 'velvet-zardozi-bridal-couture-lehenga', 'Saree', 'Micro Velvet & Net Flared Base', 'Dabka, Nakshi & Zardozi Hand Embroidery', 'Pure Gold Bullion Zari & French Knots', 'Double Dupatta Styling Set (Velvet + Net)', 'Fully Hand-Embroidered Velvet Blouse (Unstitched)', 'Bridal Wedding Ceremony', 32000.00, 24999.00, 7999.00, 11500.00, 1, 4, 8, 24, 25, 5.0, 310, '/assets/images/product6.png', 'Bridal Couture', 'in_stock', 'Royal bridal velvet lehenga with over 180 hours of hand-embroidered dabka, nakshi, and zardozi detailing.')
ON DUPLICATE KEY UPDATE 
    title=VALUES(title), 
    category_name=VALUES(category_name), 
    fabric=VALUES(fabric), 
    retail_price=VALUES(retail_price), 
    wholesale_price=VALUES(wholesale_price), 
    reseller_price=VALUES(reseller_price), 
    stock_qty=VALUES(stock_qty), 
    status=VALUES(status),
    primary_image=VALUES(primary_image);
