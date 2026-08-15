<?php
/**
 * singelprodut.php — Dedicated Luxury Single Product Page (PDP)
 * Fully responsive on Mobile and Desktop with touch-swipe gallery,
 * Size Chart Modal, Pincode Estimator, WhatsApp Order, and Cart Integration.
 */

$products = [
    1 => [
        'id'       => 1,
        'name'     => 'Nilambari Silk Saree',
        'category' => 'Sarees',
        'price'    => 4899,
        'old_price'=> 6500,
        'discount' => 25,
        'image'    => 'images/product1.png',
        'badge'    => 'New',
        'rating'   => 4.8,
        'reviews'  => 142,
        'color'    => 'Navy',
        'colors'   => ['Navy', 'Royal Blue', 'Midnight Black'],
        'size'     => ['Free Size', 'M', 'L'],
        'fabric'   => 'Pure Kanchipuram Silk',
        'in_stock' => true,
        'sku'      => 'KN-SAR-001',
        'desc'     => 'An exquisite masterpiece from our Royal Heritage edit. The Nilambari Silk Saree features pure gold zari brocade work along the pallu, finished with artisanal floral buttas and rich temple borders.'
    ],
    2 => [
        'id'       => 2,
        'name'     => 'Banarasi Zari Saree',
        'category' => 'Sarees',
        'price'    => 8499,
        'old_price'=> 11000,
        'discount' => 23,
        'image'    => 'images/product2.png',
        'badge'    => 'Bestseller',
        'rating'   => 4.9,
        'reviews'  => 218,
        'color'    => 'Maroon',
        'colors'   => ['Maroon', 'Deep Wine', 'Ruby Red'],
        'size'     => ['Free Size', 'S', 'M'],
        'fabric'   => 'Pure Banarasi Katan Silk',
        'in_stock' => true,
        'sku'      => 'KN-SAR-002',
        'desc'     => 'Handwoven in Varanasi using centuries-old kadhwa weaving techniques. Adorned with delicate antique gold floral jaal, this saree exudes regal Indian heritage.'
    ],
    3 => [
        'id'       => 3,
        'name'     => 'Kanjivaram Temple Silk',
        'category' => 'Sarees',
        'price'    => 12999,
        'old_price'=> 16500,
        'discount' => 21,
        'image'    => 'images/product3.png',
        'badge'    => 'Heritage',
        'rating'   => 5.0,
        'reviews'  => 96,
        'color'    => 'Yellow',
        'colors'   => ['Yellow', 'Golden Ochre', 'Emerald Green'],
        'size'     => ['Free Size', 'L', 'XL'],
        'fabric'   => 'Pure Mulberry Silk (3-Ply)',
        'in_stock' => true,
        'sku'      => 'KN-SAR-003',
        'desc'     => 'Woven with three-ply twisted silk yarn and dipped in pure metallic gold zari. Features monumental temple gopuram motifs along the double-wide contrast border.'
    ],
    4 => [
        'id'       => 4,
        'name'     => 'Georgette Bloom Saree',
        'category' => 'Sarees',
        'price'    => 3299,
        'old_price'=> 4200,
        'discount' => 21,
        'image'    => 'images/product4.png',
        'badge'    => null,
        'rating'   => 4.6,
        'reviews'  => 74,
        'color'    => 'Pink',
        'colors'   => ['Pink', 'Blush Peach', 'Rose'],
        'size'     => ['Free Size', 'S', 'M', 'L'],
        'fabric'   => 'Viscose Georgette',
        'in_stock' => true,
        'sku'      => 'KN-SAR-004',
        'desc'     => 'Lightweight, fluid, and romantic. Decorated with hand-embroidered resham florals and delicate scalloped borders for celebratory evening soirees.'
    ],
    5 => [
        'id'       => 5,
        'name'     => 'Royal Anarkali Kurti',
        'category' => 'Kurtis',
        'price'    => 2799,
        'old_price'=> 3900,
        'discount' => 28,
        'image'    => 'images/product5.png',
        'badge'    => 'New',
        'rating'   => 4.7,
        'reviews'  => 89,
        'color'    => 'Green',
        'colors'   => ['Green', 'Teal', 'Mint'],
        'size'     => ['XS', 'S', 'M', 'L', 'XL'],
        'fabric'   => 'Chanderi Silk Cotton',
        'in_stock' => true,
        'sku'      => 'KN-KUR-005',
        'desc'     => 'Flared 32-kali royal floor-length anarkali silhouette with intricate gota patti handwork on the yoke and bell sleeves.'
    ],
    6 => [
        'id'       => 6,
        'name'     => 'Bridal Zardosi Lehenga',
        'category' => 'Lehengas',
        'price'    => 24999,
        'old_price'=> 32000,
        'discount' => 22,
        'image'    => 'images/product6.png',
        'badge'    => 'Bridal',
        'rating'   => 5.0,
        'reviews'  => 310,
        'color'    => 'Red',
        'colors'   => ['Red', 'Crimson', 'Maroon'],
        'size'     => ['S', 'M', 'L', 'XL'],
        'fabric'   => 'Raw Silk & Velvet Dupatta',
        'in_stock' => true,
        'sku'      => 'KN-LEH-006',
        'desc'     => 'A couture bridal creation featuring 180 hours of meticulous dabka, nakshi, and zardozi bullion embroidery over deep crimson silk, complete with dual dupattas.'
    ],
    7 => [
        'id'       => 7,
        'name'     => 'Mustard Block Print Saree',
        'category' => 'Sarees',
        'price'    => 1899,
        'old_price'=> 2600,
        'discount' => 27,
        'image'    => 'images/product7.png',
        'badge'    => null,
        'rating'   => 4.5,
        'reviews'  => 56,
        'color'    => 'Orange',
        'colors'   => ['Orange', 'Mustard', 'Rust Gold'],
        'size'     => ['Free Size', 'M'],
        'fabric'   => 'Mulmul Cotton',
        'in_stock' => true,
        'sku'      => 'KN-SAR-007',
        'desc'     => 'Authentic Bagru hand block printed natural vegetable dyes on airy mulmul cotton. Perfect for daytime cultural gatherings and warm weather celebrations.'
    ],
    8 => [
        'id'       => 8,
        'name'     => 'Ivory Designer Gown',
        'category' => 'Gowns',
        'price'    => 7499,
        'old_price'=> 9500,
        'discount' => 21,
        'image'    => 'images/product8.png',
        'badge'    => 'Trending',
        'rating'   => 4.8,
        'reviews'  => 115,
        'color'    => 'White',
        'colors'   => ['White', 'Ivory', 'Pearl Cream'],
        'size'     => ['S', 'M', 'L', 'XXL'],
        'fabric'   => 'Organza & Silk Crepe',
        'in_stock' => true,
        'sku'      => 'KN-GWN-008',
        'desc'     => 'Dramatic cape-sleeved indo-western evening gown embellished with swarovski crystals and tone-on-tone pearl embroidery.'
    ],
];

// Resolve requested product ID (Default to #1)
$pid = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$product = $products[$pid] ?? $products[1];

// Generate variation gallery images
$galleryImages = [
    $product['image'],
    'https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=800&q=80'
];

// Myntra-Style Detailed Product Specifications
$myntraSpecsMap = [
    1 => [
        ['title' => 'Type', 'val' => 'Banarasi'],
        ['title' => 'Ornamentation', 'val' => 'Zari'],
        ['title' => 'Border', 'val' => 'Woven Design'],
        ['title' => 'Blouse Fabric', 'val' => 'Silk Blend'],
        ['title' => 'Blouse', 'val' => 'Blouse Piece'],
        ['title' => 'Saree Fabric', 'val' => 'Pure Silk'],
        ['title' => 'Wash Care', 'val' => 'Dry Clean Only'],
        ['title' => 'Net Quantity', 'val' => '1'],
    ],
    2 => [
        ['title' => 'Type', 'val' => 'Banarasi'],
        ['title' => 'Ornamentation', 'val' => 'Zari Jacquard'],
        ['title' => 'Border', 'val' => 'Antique Gold Zari'],
        ['title' => 'Blouse Fabric', 'val' => 'Katan Silk'],
        ['title' => 'Blouse', 'val' => 'Blouse Piece'],
        ['title' => 'Saree Fabric', 'val' => 'Katan Silk'],
        ['title' => 'Wash Care', 'val' => 'Dry Clean Only'],
        ['title' => 'Net Quantity', 'val' => '1'],
    ],
    3 => [
        ['title' => 'Type', 'val' => 'Kasavu'],
        ['title' => 'Ornamentation', 'val' => 'Zari'],
        ['title' => 'Border', 'val' => 'Woven Design'],
        ['title' => 'Blouse Fabric', 'val' => 'Tissue'],
        ['title' => 'Blouse', 'val' => 'Blouse Piece'],
        ['title' => 'Saree Fabric', 'val' => 'Tissue'],
        ['title' => 'Wash Care', 'val' => 'Dry Clean Only'],
        ['title' => 'Net Quantity', 'val' => '1'],
    ],
    4 => [
        ['title' => 'Type', 'val' => 'Georgette'],
        ['title' => 'Ornamentation', 'val' => 'Resham Threadwork'],
        ['title' => 'Border', 'val' => 'Scalloped Floral'],
        ['title' => 'Blouse Fabric', 'val' => 'Georgette'],
        ['title' => 'Blouse', 'val' => 'Blouse Piece'],
        ['title' => 'Saree Fabric', 'val' => 'Viscose Georgette'],
        ['title' => 'Wash Care', 'val' => 'Dry Clean Only'],
        ['title' => 'Net Quantity', 'val' => '1'],
    ],
    5 => [
        ['title' => 'Type', 'val' => 'Anarkali'],
        ['title' => 'Ornamentation', 'val' => 'Gota Patti'],
        ['title' => 'Border', 'val' => 'Flared Kali Hem'],
        ['title' => 'Blouse Fabric', 'val' => 'Chanderi Cotton'],
        ['title' => 'Blouse', 'val' => 'Kurti & Dupatta Set'],
        ['title' => 'Saree Fabric', 'val' => 'Chanderi Silk Cotton'],
        ['title' => 'Wash Care', 'val' => 'Dry Clean Only'],
        ['title' => 'Net Quantity', 'val' => '1'],
    ],
    6 => [
        ['title' => 'Type', 'val' => 'Bridal Lehenga'],
        ['title' => 'Ornamentation', 'val' => 'Zardozi & Dabka'],
        ['title' => 'Border', 'val' => 'Heavy Embroidered'],
        ['title' => 'Blouse Fabric', 'val' => 'Raw Silk & Velvet'],
        ['title' => 'Blouse', 'val' => 'Choli Piece with Dupatta'],
        ['title' => 'Saree Fabric', 'val' => 'Raw Silk & Velvet'],
        ['title' => 'Wash Care', 'val' => 'Specialist Dry Clean'],
        ['title' => 'Net Quantity', 'val' => '1'],
    ],
    7 => [
        ['title' => 'Type', 'val' => 'Bagru Block Print'],
        ['title' => 'Ornamentation', 'val' => 'Natural Vegetable Dye'],
        ['title' => 'Border', 'val' => 'Printed Zari Border'],
        ['title' => 'Blouse Fabric', 'val' => 'Mulmul Cotton'],
        ['title' => 'Blouse', 'val' => 'Blouse Piece'],
        ['title' => 'Saree Fabric', 'val' => 'Mulmul Cotton'],
        ['title' => 'Wash Care', 'val' => 'Gentle Hand Wash'],
        ['title' => 'Net Quantity', 'val' => '1'],
    ],
    8 => [
        ['title' => 'Type', 'val' => 'Indo-Western Gown'],
        ['title' => 'Ornamentation', 'val' => 'Swarovski & Pearls'],
        ['title' => 'Border', 'val' => 'Flowing Cape Hem'],
        ['title' => 'Blouse Fabric', 'val' => 'Organza Silk'],
        ['title' => 'Blouse', 'val' => 'Attached Cape Set'],
        ['title' => 'Saree Fabric', 'val' => 'Organza & Silk Crepe'],
        ['title' => 'Wash Care', 'val' => 'Dry Clean Only'],
        ['title' => 'Net Quantity', 'val' => '1'],
    ],
];
$currentSpecs = $myntraSpecsMap[$pid] ?? $myntraSpecsMap[3];

// Myntra-Style Detailed Product Descriptions (Design Details, Size & Fit, Material & Care)
$myntraProductDetailsMap = [
    1 => [
        'design_lines' => [
            'Midnight Blue and Royal Gold-Toned Banarasi Silk saree',
            'Intricate floral jaal woven design with contrast zari border',
            'Has Zari detail',
            'The saree comes with an unstitched blouse piece',
            'The blouse worn by the model might be for modelling purpose only. Check the image of the blouse piece to understand how the actual blouse piece looks like.',
            'Special Occasion: Wedding & Festive Reception'
        ],
        'size_fit' => [
            'Length: 5.5 metres plus 0.8 metre blouse piece',
            'Width: 1.06 metres (approx.)'
        ],
        'material_care' => [
            'Saree fabric: Pure Banarasi Katan Silk',
            'Blouse fabric: Pure Silk Blend',
            'Wash Care: Dry Clean Only'
        ]
    ],
    2 => [
        'design_lines' => [
            'Deep Wine and Ruby Red Banarasi Zari saree',
            'Centuries-old kadhwa weaving technique with rich gold zari motifs',
            'Opulent pallu with floral jaal and double zari border',
            'The saree comes with an unstitched blouse piece',
            'The blouse worn by the model might be for modelling purpose only. Check the image of the blouse piece to understand how the actual blouse piece looks like.',
            'Special Occasion: Bridal & Royal Gala'
        ],
        'size_fit' => [
            'Length: 5.5 metres plus 0.8 metre blouse piece',
            'Width: 1.06 metres (approx.)'
        ],
        'material_care' => [
            'Saree fabric: Pure Katan Silk',
            'Blouse fabric: Katan Silk',
            'Wash Care: Dry Clean Only'
        ]
    ],
    3 => [
        'design_lines' => [
            'Off White and Gold-Toned Kasavu sarees',
            'Woven Design saree with Woven Design Border border',
            'Has Zari detail',
            'The saree comes with an unstitched blouse piece',
            'The blouse worn by the model might be for modelling purpose only. Check the image of the blouse piece to understand how the actual blouse piece looks like.',
            'Special Occasion: Onam'
        ],
        'size_fit' => [
            'Length: 5.5 metres plus 0.8 metre blouse piece',
            'Width: 1.06 metres (approx.)'
        ],
        'material_care' => [
            'Saree fabric: Silk Blend',
            'Blouse fabric: Silk Blend',
            'Wash Care: Machine wash'
        ]
    ],
    4 => [
        'design_lines' => [
            'Blush Pink floral embroidered Viscose Georgette saree',
            'Hand-embroidered resham florals and delicate scalloped borders',
            'Lightweight, fluid drape with romantic evening sheen',
            'The saree comes with an unstitched blouse piece',
            'The blouse worn by the model might be for modelling purpose only. Check the image of the blouse piece to understand how the actual blouse piece looks like.',
            'Special Occasion: Evening Soiree & Cocktail'
        ],
        'size_fit' => [
            'Length: 5.5 metres plus 0.8 metre blouse piece',
            'Width: 1.06 metres (approx.)'
        ],
        'material_care' => [
            'Saree fabric: Viscose Georgette',
            'Blouse fabric: Georgette',
            'Wash Care: Dry Clean Only'
        ]
    ],
    5 => [
        'design_lines' => [
            'Emerald Green Royal Anarkali Floor-Length Kurti Set',
            '32-kali flared silhouette with intricate gota patti handwork on yoke and bell sleeves',
            'Comes with matching churidar and sheer organza dupatta',
            'Special Occasion: Festive Celebrations & Sangeet'
        ],
        'size_fit' => [
            'Kurti Length: 52 inches (Floor Length)',
            'Sleeve Length: 3/4th Bell Sleeves',
            'Dupatta: 2.25 metres'
        ],
        'material_care' => [
            'Kurti & Churidar: Chanderi Silk Cotton',
            'Dupatta: Pure Organza',
            'Wash Care: Dry Clean Only'
        ]
    ],
    6 => [
        'design_lines' => [
            'Crimson Red Bridal Zardosi Couture Lehenga Set',
            '180 hours of hand-embroidery with dabka, nakshi, and zardozi bullion',
            'Complete with heavily embellished choli and dual dupattas (Velvet & Net)',
            'Special Occasion: Royal Wedding & Pheras'
        ],
        'size_fit' => [
            'Lehenga Flare (Gher): 4.5 metres',
            'Lehenga Length: 43 inches',
            'Choli Fabric: 1.2 metres (Unstitched)'
        ],
        'material_care' => [
            'Lehenga & Choli: Raw Silk & Velvet',
            'Dupatta: Soft Net & Velvet Border',
            'Wash Care: Specialist Dry Clean Only'
        ]
    ],
    7 => [
        'design_lines' => [
            'Mustard & Indigo Bagru Hand Block Printed Saree',
            'Handcrafted using traditional wooden block carving and natural vegetable dyes',
            'Soft breathable drape with geometric zari border',
            'The saree comes with an unstitched blouse piece',
            'Special Occasion: Daytime Cultural & Festive Events'
        ],
        'size_fit' => [
            'Length: 5.5 metres plus 0.8 metre blouse piece',
            'Width: 1.06 metres (approx.)'
        ],
        'material_care' => [
            'Saree fabric: 100% Mulmul Cotton',
            'Blouse fabric: Mulmul Cotton',
            'Wash Care: Gentle Hand Wash in Cold Water'
        ]
    ],
    8 => [
        'design_lines' => [
            'Ivory & Pearl Tone-on-Tone Embroidered Evening Gown',
            'Dramatic sheer cape sleeves embellished with authentic Swarovski crystals',
            'Modern indo-western structured silhouette',
            'Special Occasion: Cocktail, Reception & Red Carpet'
        ],
        'size_fit' => [
            'Gown Length: 56 inches',
            'Cape Length: Floor-Sweeping (58 inches)'
        ],
        'material_care' => [
            'Fabric: Organza & Silk Crepe',
            'Lining: Butter Crepe',
            'Wash Care: Dry Clean Only'
        ]
    ]
];
$currentDetails = $myntraProductDetailsMap[$pid] ?? $myntraProductDetailsMap[3];

$customerReviews = [
    [
        'id' => 1,
        'name' => 'Priya Sharma',
        'city' => 'Mumbai, MH',
        'rating' => 5,
        'date' => '2 days ago',
        'occasion' => 'Wedding Sangeet',
        'text' => 'The fabric quality and real zari weave is breathtaking! Arrived in luxury royal gift packaging within 3 days to Mumbai. Wore it for my cousin’s sangeet and received endless compliments.',
        'photo' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=400&q=80',
        'helpful' => 38
    ],
    [
        'id' => 2,
        'name' => 'Ananya Mehta',
        'city' => 'Surat, Gujarat',
        'rating' => 5,
        'date' => '4 days ago',
        'occasion' => 'Diwali Festive Puja',
        'text' => 'Exactly as depicted in the photos. The silk drape feels extremely luxurious, pure, and lightweight. The WhatsApp styling concierge was very helpful with size selection.',
        'photo' => 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?auto=format&fit=crop&w=400&q=80',
        'helpful' => 29
    ],
    [
        'id' => 3,
        'name' => 'Dr. Radhika Iyer',
        'city' => 'Bengaluru, KA',
        'rating' => 5,
        'date' => '1 week ago',
        'occasion' => 'Temple Inauguration',
        'text' => 'Authentic handloom craftsmanship. You can tell the zari is high standard and pure. Stitching of the blouse piece was flawless. Highly recommend Kalaniketan!',
        'photo' => null,
        'helpful' => 21
    ],
    [
        'id' => 4,
        'name' => 'Sneha Singhania',
        'city' => 'Delhi NCR',
        'rating' => 5,
        'date' => '1 week ago',
        'occasion' => 'Reception Night',
        'text' => 'The color is deep, royal, and rich under evening chandelier lighting. Everyone asked where I purchased it from. Fast express delivery with zero hassle.',
        'photo' => 'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=400&q=80',
        'helpful' => 44
    ],
    [
        'id' => 5,
        'name' => 'Kavita Patel',
        'city' => 'London, UK',
        'rating' => 5,
        'date' => '2 weeks ago',
        'occasion' => 'International Wedding',
        'text' => 'Ordered from London with international DHL shipping. Reached in 5 business days in pristine condition! Truly magnificent quality and authentic silk sheen.',
        'photo' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?auto=format&fit=crop&w=400&q=80',
        'helpful' => 52
    ],
    [
        'id' => 6,
        'name' => 'Meera Deshmukh',
        'city' => 'Pune, MH',
        'rating' => 4,
        'date' => '3 weeks ago',
        'occasion' => 'Engagement Ceremony',
        'text' => 'Beautiful attire! Heavy royal border and very comfortable to wear all night. Delivery was smooth and packaging was top notch.',
        'photo' => null,
        'helpful' => 17
    ],
    [
        'id' => 7,
        'name' => 'Ritu Kothari',
        'city' => 'Jaipur, RJ',
        'rating' => 5,
        'date' => '1 month ago',
        'occasion' => 'Sister’s Haldi',
        'text' => 'Outstanding royal craftsmanship! The zari sheen is so authentic and looks 10x better in person than online. Everyone at the event kept asking about Kalaniketan.',
        'photo' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=400&q=80',
        'helpful' => 31
    ]
];

$colorHex = [
    'Navy' => '#1B2A4A', 'Royal Blue' => '#204B8C', 'Midnight Black' => '#1A1A1A',
    'Maroon' => '#6D1A24', 'Deep Wine' => '#4A1521', 'Ruby Red' => '#9E1B32',
    'Yellow' => '#E5A93B', 'Golden Ochre' => '#C68B29', 'Emerald Green' => '#1E5E3A',
    'Pink' => '#E88B9E', 'Blush Peach' => '#F4B2A0', 'Rose' => '#D46A84',
    'Green' => '#2D6A4F', 'Teal' => '#1D6870', 'Mint' => '#74B39B',
    'Red' => '#B22222', 'Crimson' => '#DC143C', 'Orange' => '#D96B27',
    'Mustard' => '#C88A24', 'Rust Gold' => '#A85A1D', 'White' => '#FAF8F5',
    'Ivory' => '#FFFFF0', 'Pearl Cream' => '#EFEBD9'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?= htmlspecialchars($product['name']) ?> — Kalaniketan | Ethnic Luxury</title>
<meta name="description" content="<?= htmlspecialchars(substr($product['desc'], 0, 160)) ?>" />
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

<style>
/* ── Design Tokens ── */
:root {
    --off-white:      #F8F6F0;
    --off-white-2:    #F2EFE8;
    --dark-gold:      #8A681F;
    --deep-gold:      #6F5218;
    --gold-pale:      #FAF3E0;
    --gold-border:    rgba(138,104,31,0.25);
    --soft-platinum:  #E5E3DE;
    --dark-text:      #24211C;
    --mid-text:       #5A5348;
    --light-text:     #9A9490;
    --font-serif:     'Cinzel', serif;
    --font-sans:      'Inter', sans-serif;
    --transition:     0.28s cubic-bezier(0.4, 0, 0.2, 1);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body {
    background: var(--off-white);
    font-family: var(--font-sans);
    color: var(--dark-text);
    -webkit-font-smoothing: antialiased;
    overflow-x: hidden;
}
img { display: block; max-width: 100%; }
a { text-decoration: none; color: inherit; }
button { font-family: inherit; cursor: pointer; border: none; background: none; }

/* ── Main Layout ── */
.pdp-main-wrapper {
    max-width: 1240px;
    margin: 0 auto;
    padding: clamp(14px, 3vw, 32px) clamp(12px, 3vw, 28px);
}

.pdp-layout-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: clamp(20px, 4vw, 48px);
    align-items: start;
}
@media (min-width: 900px) {
    .pdp-layout-grid {
        grid-template-columns: 48% 52%;
    }
}

/* ════════════════════════════════════════════════════
   LEFT COLUMN: TOUCH-SWIPEABLE GALLERY & SLIDER
════════════════════════════════════════════════════ */
.pdp-gallery-column {
    display: flex;
    flex-direction: column;
    gap: 12px;
    position: relative;
    max-width: 500px;
    width: 100%;
    margin: 0 auto;
}
@media (min-width: 900px) {
    .pdp-gallery-column {
        position: sticky;
        top: 80px;
        margin: 0 0 0 auto;
    }
}

/* Main Image Slider Viewport (Elegant Vertical Fashion Portrait) */
.pdp-gallery-slider {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    background: #FAF8F4;
    aspect-ratio: 3 / 3.85;
    max-height: 580px;
    width: 100%;
    margin: 0 auto;
    border: 1px solid rgba(138, 104, 31, 0.22);
    box-shadow: 0 8px 28px rgba(0,0,0,0.06);
}

@media (max-width: 767px) {
    .pdp-main-wrapper {
        padding: 8px 10px 24px;
    }
    .pdp-gallery-column {
        max-width: 100%;
        gap: 10px;
    }
    .pdp-gallery-slider {
        aspect-ratio: 3 / 3.75;
        max-height: 480px;
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(0,0,0,0.08);
    }
}

/* Swipeable Track */
.pdp-slider-track {
    display: flex;
    width: 100%;
    height: 100%;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    scrollbar-width: none;
    -webkit-overflow-scrolling: touch;
    overscroll-behavior-x: contain;
    touch-action: pan-y pinch-zoom;
}
.pdp-slider-track::-webkit-scrollbar { display: none; }

.pdp-slide {
    flex: 0 0 100%;
    width: 100%;
    height: 100%;
    scroll-snap-align: start;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #FAF8F4;
}
.pdp-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
    user-select: none;
    -webkit-user-drag: none;
    cursor: zoom-in;
    transition: transform 0.4s ease;
}

/* Slide Counter Badge (Mobile) */
.pdp-slide-counter {
    position: absolute;
    bottom: 12px;
    right: 12px;
    background: rgba(24, 21, 18, 0.78);
    backdrop-filter: blur(8px);
    color: #FFFFFF;
    font-size: 0.68rem;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.25);
    letter-spacing: 0.08em;
    z-index: 5;
    box-shadow: 0 2px 8px rgba(0,0,0,0.25);
}

/* Slider Navigation Arrows */
.pdp-slider-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 38px; height: 38px;
    border-radius: 50%;
    background: rgba(255,255,255,0.92);
    backdrop-filter: blur(6px);
    border: 1px solid var(--gold-border);
    color: var(--dark-gold);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    z-index: 6;
    transition: all 0.2s ease;
    box-shadow: 0 4px 14px rgba(0,0,0,0.14);
}
.pdp-slider-arrow:hover {
    background: var(--dark-gold);
    color: #FFFFFF;
    transform: translateY(-50%) scale(1.08);
}
.pdp-slider-arrow.prev { left: 12px; }
.pdp-slider-arrow.next { right: 12px; }
.pdp-slider-arrow svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2.4; }

@media (max-width: 767px) {
    .pdp-slider-arrow { display: none; }
}

/* Badge Tag */
.pdp-badge-tag {
    position: absolute;
    top: 12px; left: 12px;
    background: rgba(138, 104, 31, 0.94);
    backdrop-filter: blur(8px);
    color: #FFFFFF;
    font-size: 0.62rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    padding: 4px 11px;
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.3);
    z-index: 5;
    box-shadow: 0 3px 10px rgba(0,0,0,0.2);
}

/* Fullscreen Zoom Trigger Icon */
.pdp-zoom-btn {
    position: absolute;
    top: 12px; right: 12px;
    width: 34px; height: 34px;
    border-radius: 50%;
    background: rgba(255,255,255,0.92);
    backdrop-filter: blur(6px);
    border: 1px solid rgba(138,104,31,0.28);
    color: var(--dark-gold);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    z-index: 5;
    transition: all 0.2s ease;
    box-shadow: 0 3px 10px rgba(0,0,0,0.12);
}
.pdp-zoom-btn:hover {
    background: var(--dark-gold);
    color: #FFFFFF;
    transform: scale(1.1);
}
.pdp-zoom-btn svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2.2; }

/* Thumbnails Strip */
.pdp-thumbnails-strip {
    display: flex;
    justify-content: center;
    gap: 8px;
    overflow-x: auto;
    padding: 4px 2px;
    scrollbar-width: none;
}
.pdp-thumbnails-strip::-webkit-scrollbar { display: none; }
.pdp-thumb-item {
    width: 56px;
    height: 70px;
    border-radius: 8px;
    overflow: hidden;
    border: 1.5px solid var(--soft-platinum);
    background: #FAF8F4;
    cursor: pointer;
    flex-shrink: 0;
    opacity: 0.75;
    transition: all 0.25s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}
.pdp-thumb-item:hover {
    opacity: 0.95;
    border-color: var(--dark-gold);
}
.pdp-thumb-item.active {
    opacity: 1;
    border-color: var(--dark-gold);
    box-shadow: 0 0 0 2px rgba(138,104,31,0.35);
    transform: translateY(-2px);
}
.pdp-thumb-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
}
@media (max-width: 767px) {
    .pdp-thumb-item {
        width: 48px;
        height: 60px;
    }
}

/* ════════════════════════════════════════════════════
   RIGHT COLUMN: PRODUCT DETAILS & CONVERSION ACTIONS
════════════════════════════════════════════════════ */
.pdp-details-column {
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.pdp-brand-tag {
    font-size: 0.68rem;
    font-weight: 800;
    color: var(--dark-gold);
    letter-spacing: 0.18em;
    text-transform: uppercase;
}
.pdp-title {
    font-family: var(--font-serif);
    font-size: clamp(1.35rem, 3.5vw, 1.95rem);
    font-weight: 800;
    color: var(--dark-text);
    line-height: 1.25;
}

/* Ratings Badge */
.pdp-rating-row {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 0.8rem;
    flex-wrap: wrap;
}
.pdp-rating-pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 10px;
    border-radius: 14px;
    background: #1B5E20;
    color: #FFFFFF;
    font-weight: 800;
    font-size: 0.76rem;
}
.pdp-rating-pill svg { width: 13px; height: 13px; fill: #FFFFFF; }
.pdp-review-count {
    color: var(--mid-text);
    font-weight: 600;
}
.pdp-sku-badge {
    margin-left: auto;
    font-size: 0.68rem;
    color: var(--light-text);
    font-weight: 700;
    letter-spacing: 0.06em;
}

/* Price Block */
.pdp-price-card {
    background: #FFFFFF;
    border: 1.5px solid var(--gold-border);
    border-radius: 12px;
    padding: 16px 20px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.03);
}
.pdp-price-main-row {
    display: flex;
    align-items: baseline;
    gap: 12px;
    flex-wrap: wrap;
}
.pdp-price-val {
    font-size: clamp(1.6rem, 4vw, 2.1rem);
    font-weight: 900;
    color: var(--dark-gold);
}
.pdp-mrp-val {
    font-size: 0.95rem;
    color: var(--light-text);
    text-decoration: line-through;
    font-weight: 500;
}
.pdp-discount-badge {
    font-size: 0.82rem;
    font-weight: 800;
    color: #8A681F;
    background: var(--gold-pale);
    padding: 4px 10px;
    border-radius: 6px;
    border: 1px solid var(--gold-border);
}
/* Animated Luxury Perks Badge Strip */
.pdp-animated-perks-strip {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 6px;
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px dashed var(--gold-border);
}
@media (max-width: 600px) {
    .pdp-animated-perks-strip {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px;
        margin-top: 8px;
        padding-top: 8px;
    }
}
.pdp-perk-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 9px;
    border-radius: 20px;
    font-size: 0.68rem;
    font-weight: 700;
    line-height: 1.2;
    transition: all 0.25s ease;
    border: 1px solid var(--gold-border);
    background: linear-gradient(135deg, #FFFFFF 0%, var(--gold-pale) 100%);
    color: var(--dark-text);
    box-shadow: 0 1px 4px rgba(138, 104, 31, 0.06);
    position: relative;
    overflow: hidden;
}
.pdp-perk-badge::after {
    content: '';
    position: absolute;
    top: 0; left: -100%; width: 60%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.7), transparent);
    animation: pdpShimmer 3.5s infinite;
}
@keyframes pdpShimmer {
    0% { left: -100%; }
    25% { left: 150%; }
    100% { left: 150%; }
}
.pdp-perk-badge:hover {
    transform: translateY(-1px);
    border-color: var(--dark-gold);
    box-shadow: 0 3px 8px rgba(138, 104, 31, 0.15);
}

.pdp-perk-quality {
    background: linear-gradient(135deg, #FFF9E6 0%, #FFF3D1 100%);
    border-color: rgba(212, 175, 55, 0.45);
    color: #7A580A;
}
.pdp-perk-tax {
    background: linear-gradient(135deg, #F8F9FA 0%, #EFF2F5 100%);
    border-color: rgba(0, 0, 0, 0.1);
    color: #4A5568;
}
.pdp-perk-delivery {
    background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%);
    border-color: rgba(46, 125, 50, 0.35);
    color: #1B5E20;
}
.pdp-perk-exchange {
    background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
    border-color: rgba(25, 118, 210, 0.35);
    color: #0D47A1;
}

.pdp-perk-svg {
    width: 14px;
    height: 14px;
    flex-shrink: 0;
    display: inline-block;
    vertical-align: middle;
}
.pdp-perk-svg.pulse {
    animation: pdpIconPulse 2s infinite ease-in-out;
}
@keyframes pdpIconPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.25); }
}
.pdp-perk-svg.flash {
    animation: pdpIconFlash 1.6s infinite ease-in-out;
}
@keyframes pdpIconFlash {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.65; transform: scale(1.2); }
}
.pdp-perk-svg.spin {
    animation: pdpIconWiggle 3.5s infinite ease-in-out;
}
@keyframes pdpIconWiggle {
    0%, 100% { transform: rotate(0deg); }
    20% { transform: rotate(-22deg); }
    60% { transform: rotate(22deg); }
    80% { transform: rotate(0deg); }
}
.pdp-perk-text {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Color Options */
.pdp-section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.78rem;
    font-weight: 800;
    color: var(--dark-text);
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 8px;
}
.pdp-selected-txt {
    color: var(--dark-gold);
    font-weight: 800;
}

.pdp-color-swatches {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}
.pdp-color-btn {
    width: 34px; height: 34px;
    border-radius: 50%;
    border: 2.5px solid #FFFFFF;
    outline: 1.5px solid var(--soft-platinum);
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
    box-shadow: 0 2px 8px rgba(0,0,0,0.12);
}
.pdp-color-btn:hover {
    outline-color: var(--dark-gold);
    transform: scale(1.12);
}
.pdp-color-btn.active {
    outline: 2.5px solid var(--dark-gold);
    box-shadow: 0 0 0 3px rgba(138,104,31,0.25), 0 4px 10px rgba(0,0,0,0.2);
    transform: scale(1.15);
}

/* Size Options */
.pdp-size-grid {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
.pdp-size-btn {
    min-width: 48px; height: 42px;
    border-radius: 9px;
    border: 1.8px solid var(--soft-platinum);
    background: #FFFFFF;
    font-size: 0.84rem;
    font-weight: 800;
    color: var(--dark-text);
    display: flex; align-items: center; justify-content: center;
    padding: 0 14px;
    transition: all 0.2s ease;
}
.pdp-size-btn:hover {
    border-color: var(--dark-gold);
    color: var(--dark-gold);
}
.pdp-size-btn.active {
    border-color: var(--dark-gold);
    background: var(--dark-gold);
    color: #FFFFFF;
    box-shadow: 0 4px 12px rgba(138,104,31,0.3);
}

.pdp-size-guide-link {
    font-size: 0.74rem;
    font-weight: 700;
    color: var(--dark-gold);
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.2s;
}
.pdp-size-guide-link:hover { text-decoration: underline; }

/* Quantity & Action CTAs */
.pdp-actions-container {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 6px;
}
.pdp-qty-row {
    display: flex;
    align-items: center;
    gap: 14px;
}
.pdp-qty-box {
    display: inline-flex;
    align-items: center;
    border: 1.8px solid var(--soft-platinum);
    border-radius: 8px;
    background: #FFFFFF;
    overflow: hidden;
}
.pdp-qty-btn {
    width: 36px; height: 38px;
    background: #FAF8F4;
    font-size: 1rem;
    font-weight: 800;
    color: var(--dark-gold);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    transition: background 0.15s;
}
.pdp-qty-btn:hover { background: var(--gold-pale); }
.pdp-qty-num {
    width: 40px;
    text-align: center;
    font-size: 0.88rem;
    font-weight: 800;
}

.pdp-btn-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
.pdp-atc-btn {
    padding: 14px 20px;
    border-radius: 9px;
    border: 2px solid var(--dark-gold);
    background: #FAF4E6;
    color: var(--dark-gold);
    font-family: var(--font-sans);
    font-size: 0.88rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: all 0.2s ease;
    cursor: pointer;
}
.pdp-atc-btn:hover {
    background: #F5E8C8;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(138,104,31,0.2);
}
.pdp-atc-btn svg {
    width: 19px; height: 19px; stroke: currentColor; fill: none; stroke-width: 2.2;
    animation: pdpBagSwing 2.4s infinite ease-in-out;
    transform-origin: top center;
    flex-shrink: 0;
}

.pdp-buy-btn {
    padding: 14px 20px;
    border-radius: 9px;
    border: none;
    background: linear-gradient(135deg, var(--dark-gold) 0%, var(--deep-gold) 100%);
    color: #FFFFFF;
    font-family: var(--font-sans);
    font-size: 0.88rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    box-shadow: 0 4px 16px rgba(138,104,31,0.32);
    transition: all 0.2s ease;
    cursor: pointer;
}
.pdp-buy-btn:hover {
    background: var(--deep-gold);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(138,104,31,0.45);
}
.pdp-buy-btn svg {
    width: 18px; height: 18px; fill: currentColor; stroke: currentColor; stroke-width: 1;
    animation: pdpBoltPulse 1.6s infinite ease-in-out;
    flex-shrink: 0;
}

/* Direct WhatsApp Order CTA */
.pdp-wa-order-btn {
    width: 100%;
    padding: 13px;
    border-radius: 9px;
    background: #25D366;
    color: #FFFFFF;
    font-weight: 800;
    font-size: 0.85rem;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    text-decoration: none;
    box-shadow: 0 4px 14px rgba(37,211,102,0.3);
    transition: all 0.2s ease;
}
.pdp-wa-order-btn:hover {
    background: #128C7E;
    transform: translateY(-2px);
}
.pdp-wa-order-btn svg { width: 19px; height: 19px; fill: currentColor; }

/* Pincode Delivery Estimator */
.pdp-delivery-box {
    background: #FFFFFF;
    border: 1.5px solid var(--soft-platinum);
    border-radius: 12px;
    padding: 16px;
}
.pdp-del-title {
    font-size: 0.78rem;
    font-weight: 800;
    color: var(--dark-text);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    display: flex; align-items: center; gap: 8px;
    margin-bottom: 10px;
}
.pdp-del-title svg { width: 18px; height: 18px; stroke: var(--dark-gold); fill: none; stroke-width: 2; }
.pdp-pincode-input-row {
    display: flex;
    gap: 8px;
}
.pdp-pincode-input {
    flex: 1;
    height: 40px;
    border: 1.5px solid var(--soft-platinum);
    border-radius: 8px;
    padding: 0 14px;
    font-family: var(--font-sans);
    font-size: 0.86rem;
    font-weight: 600;
    outline: none;
}
.pdp-pincode-input:focus {
    border-color: var(--dark-gold);
}
.pdp-pincode-btn {
    padding: 0 18px;
    height: 40px;
    border-radius: 8px;
    background: var(--dark-gold);
    color: #FFFFFF;
    font-size: 0.8rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    cursor: pointer;
    transition: all 0.2s;
}
.pdp-pincode-btn:hover { background: var(--deep-gold); }
.pdp-pincode-result {
    font-size: 0.76rem;
    font-weight: 600;
    margin-top: 10px;
    display: none;
    line-height: 1.4;
}

/* ── Luxury Accordion & Specifications Section ─────────────────────── */
.pdp-accordion-wrap {
    margin-top: 14px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.pdp-acc-item {
    background: #FFFFFF;
    border: 1.5px solid var(--gold-border, rgba(138, 104, 31, 0.22));
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
    transition: all 0.25s ease;
}
.pdp-acc-item:hover {
    border-color: var(--dark-gold, #8A681F);
    box-shadow: 0 4px 16px rgba(138, 104, 31, 0.08);
}
.pdp-acc-item.open {
    border-color: var(--dark-gold, #8A681F);
    background: #FFFFFF;
    box-shadow: 0 4px 18px rgba(138, 104, 31, 0.1);
}

.pdp-acc-header {
    width: 100%;
    padding: 13px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: transparent;
    border: none;
    cursor: pointer;
    text-align: left;
    gap: 12px;
    transition: background 0.2s ease;
}
.pdp-acc-header:hover {
    background: rgba(138, 104, 31, 0.03);
}

.pdp-acc-title-group {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
}

.pdp-acc-icon-box {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: var(--gold-pale, #FAF4E6);
    border: 1px solid var(--gold-border, rgba(138, 104, 31, 0.25));
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--dark-gold, #8A681F);
    flex-shrink: 0;
    transition: all 0.25s ease;
}
.pdp-acc-item.open .pdp-acc-icon-box {
    background: var(--dark-gold, #8A681F);
    color: #FFFFFF;
    border-color: var(--dark-gold, #8A681F);
}
.pdp-acc-icon-box svg {
    width: 16px;
    height: 16px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2;
}

.pdp-acc-title-text {
    font-family: var(--font-sans, 'Inter', sans-serif);
    font-size: 0.82rem;
    font-weight: 800;
    color: var(--dark-text, #24211C);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    line-height: 1.3;
}

.pdp-acc-chevron-wrap {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: #FAF8F4;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--dark-gold, #8A681F);
    flex-shrink: 0;
    transition: all 0.25s ease;
}
.pdp-acc-chevron {
    width: 14px;
    height: 14px;
    stroke: currentColor;
    stroke-width: 2.5;
    fill: none;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.pdp-acc-item.open .pdp-acc-chevron {
    transform: rotate(180deg);
}

.pdp-acc-body {
    display: none;
    padding: 0 16px 16px;
    font-size: 0.82rem;
    color: var(--mid-text, #5A5348);
    line-height: 1.65;
    border-top: 1px dashed rgba(138, 104, 31, 0.15);
    margin-top: 2px;
    padding-top: 14px;
    animation: pdpFadeSlide 0.25s ease-out;
}
@keyframes pdpFadeSlide {
    from { opacity: 0; transform: translateY(-4px); }
    to { opacity: 1; transform: translateY(0); }
}
.pdp-acc-item.open .pdp-acc-body {
    display: block;
}

/* Feature tags inside description */
.pdp-desc-highlights {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: 12px;
}
.pdp-desc-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 9px;
    background: #FAF8F4;
    border: 1px solid var(--soft-platinum, #E5E3DE);
    border-radius: 6px;
    font-size: 0.72rem;
    font-weight: 700;
    color: var(--dark-gold, #8A681F);
}
.pdp-desc-pill svg {
    width: 13px;
    height: 13px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2;
}

/* ── Myntra-Style Product Details (Accordion 1) ─────────────────────── */
.pdp-myntra-details-wrap {
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.pdp-myntra-section-block {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.pdp-myntra-heading {
    font-size: 0.88rem;
    font-weight: 800;
    color: #282C3F;
    letter-spacing: 0.02em;
    margin: 0;
}
.pdp-myntra-list {
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.pdp-myntra-list-item {
    font-size: 0.83rem;
    color: #535766;
    line-height: 1.5;
}
.pdp-myntra-disclaimer {
    font-size: 0.77rem;
    color: #7E818C;
    line-height: 1.45;
    background: #FAF9F6;
    padding: 8px 12px;
    border-radius: 6px;
    border-left: 3px solid var(--dark-gold, #8A681F);
    margin-top: 4px;
}

/* ── Myntra-Style Specifications ────────────────────────────── */
.pdp-myntra-spec-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    column-gap: 24px;
    row-gap: 0;
}
.pdp-myntra-spec-cell {
    display: flex;
    flex-direction: column;
    padding: 10px 0;
    border-bottom: 1px solid #EAEAEC;
}
.pdp-myntra-spec-title {
    font-size: 0.74rem;
    color: #7E818C;
    font-weight: 500;
    margin-bottom: 3px;
    letter-spacing: 0.01em;
}
.pdp-myntra-spec-val {
    font-size: 0.86rem;
    font-weight: 600;
    color: #282C3F;
    line-height: 1.3;
}
@media (max-width: 480px) {
    .pdp-myntra-spec-grid {
        column-gap: 16px;
    }
    .pdp-myntra-spec-cell {
        padding: 8px 0;
    }
    .pdp-myntra-spec-title {
        font-size: 0.68rem;
    }
    .pdp-myntra-spec-val {
        font-size: 0.82rem;
    }
}

/* Shipping, Authentic & Fast Exchange Cards */
.pdp-trust-cards-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.pdp-trust-mini-card {
    display: flex;
    align-items: flex-start;
    gap: 11px;
    padding: 10px 12px;
    border-radius: 9px;
    background: #FAF8F4;
    border: 1px solid rgba(138, 104, 31, 0.15);
}
.pdp-trust-mini-card.gold {
    background: linear-gradient(135deg, #FFFDF7 0%, #FAF4E6 100%);
    border-color: rgba(212, 175, 55, 0.35);
}
.pdp-trust-mini-card.green {
    background: linear-gradient(135deg, #F8FCF8 0%, #E8F5E9 100%);
    border-color: rgba(46, 125, 50, 0.25);
}
.pdp-trust-mini-card.blue {
    background: linear-gradient(135deg, #F8FAFD 0%, #E3F2FD 100%);
    border-color: rgba(25, 118, 210, 0.25);
}

.pdp-trust-mini-icon {
    width: 28px;
    height: 28px;
    border-radius: 7px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.pdp-trust-mini-card.gold .pdp-trust-mini-icon {
    background: rgba(138, 104, 31, 0.12);
    color: #8A681F;
}
.pdp-trust-mini-card.green .pdp-trust-mini-icon {
    background: rgba(46, 125, 50, 0.12);
    color: #2E7D32;
}
.pdp-trust-mini-card.blue .pdp-trust-mini-icon {
    background: rgba(25, 118, 210, 0.12);
    color: #1976D2;
}
.pdp-trust-mini-icon svg {
    width: 15px;
    height: 15px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2;
}

.pdp-trust-mini-text h5 {
    font-size: 0.78rem;
    font-weight: 800;
    color: var(--dark-text, #24211C);
    margin: 0 0 2px 0;
}
.pdp-trust-mini-text p {
    font-size: 0.72rem;
    color: var(--mid-text, #5A5348);
    margin: 0;
    line-height: 1.4;
}

/* ════════════════════════════════════════════════════
   CUSTOMER REVIEWS & BREAKDOWN SECTION
════════════════════════════════════════════════════ */
/* ════════════════════════════════════════════════════
   CUSTOMER REVIEWS & BREAKDOWN SECTION
════════════════════════════════════════════════════ */
.pdp-reviews-section {
    margin-top: clamp(36px, 5vw, 60px);
    background: #FFFFFF;
    border: 1.5px solid var(--gold-border);
    border-radius: 16px;
    padding: clamp(20px, 4vw, 36px);
    box-shadow: 0 6px 24px rgba(0,0,0,0.03);
}

.pdp-rev-header-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
    border-bottom: 1.5px solid var(--soft-platinum);
    padding-bottom: 24px;
    align-items: center;
}
@media (min-width: 768px) {
    .pdp-rev-header-grid {
        grid-template-columns: 220px 1fr auto;
    }
}
.pdp-overall-score {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: var(--gold-pale);
    border-radius: 12px;
    padding: 16px;
    text-align: center;
    border: 1px solid var(--gold-border);
}
.pdp-big-rating {
    font-size: 2.8rem;
    font-weight: 900;
    color: var(--dark-gold);
    line-height: 1;
}
.pdp-big-stars {
    color: #F59E0B;
    font-size: 1.2rem;
    margin: 6px 0;
}
.pdp-score-sub {
    font-size: 0.72rem;
    color: var(--mid-text);
    font-weight: 600;
}

.pdp-bars-wrap {
    display: flex;
    flex-direction: column;
    gap: 7px;
    justify-content: center;
}
.pdp-bar-row {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--dark-text);
}
.pdp-bar-track {
    flex: 1;
    height: 8px;
    background: var(--soft-platinum);
    border-radius: 4px;
    overflow: hidden;
}
.pdp-bar-fill {
    height: 100%;
    background: var(--dark-gold);
    border-radius: 4px;
}

/* Write Review CTA Button */
.pdp-write-rev-btn {
    padding: 12px 20px;
    border-radius: 9px;
    border: 1.5px solid var(--dark-gold);
    background: #FFFFFF;
    color: var(--dark-gold);
    font-family: var(--font-sans);
    font-size: 0.8rem;
    font-weight: 800;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
}
.pdp-write-rev-btn:hover {
    background: var(--dark-gold);
    color: #FFFFFF;
    box-shadow: 0 4px 14px rgba(138,104,31,0.25);
}

/* Auto-Sliding Carousel Wrapper */
.pdp-reviews-carousel-wrap {
    position: relative;
    margin-top: 18px;
}
.pdp-reviews-track {
    display: flex;
    gap: 14px;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    scrollbar-width: none;
    -webkit-overflow-scrolling: touch;
    padding: 6px 2px 14px;
    touch-action: pan-y pinch-zoom;
    overscroll-behavior-x: contain;
}
.pdp-reviews-track::-webkit-scrollbar { display: none; }

/* Review Card — Compact Luxury Small Size */
.pdp-review-card {
    flex: 0 0 270px;
    max-width: 290px;
    scroll-snap-align: start;
    background: var(--off-white);
    border-radius: 12px;
    padding: 14px 16px;
    border: 1.2px solid var(--soft-platinum);
    box-shadow: 0 3px 12px rgba(0,0,0,0.03);
    display: flex;
    flex-direction: column;
    gap: 8px;
    transition: all 0.25s ease;
}
@media (max-width: 600px) {
    .pdp-review-card {
        flex: 0 0 250px;
        max-width: 265px;
        padding: 12px 14px;
    }
}
.pdp-review-card:hover {
    border-color: var(--dark-gold);
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(138,104,31,0.12);
}

.pdp-rc-top {
    display: flex;
    align-items: center;
    gap: 8px;
}
.pdp-rc-avatar {
    width: 32px; height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--dark-gold) 0%, var(--deep-gold) 100%);
    color: #FFFFFF;
    font-size: 0.75rem;
    font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.pdp-rc-meta {
    display: flex;
    flex-direction: column;
    gap: 1px;
    flex: 1;
    min-width: 0;
}
.pdp-rc-name {
    font-size: 0.82rem;
    font-weight: 800;
    color: var(--dark-text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.pdp-rc-rating-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 3px;
    flex-shrink: 0;
}
.pdp-verified-badge {
    display: inline-flex;
    align-items: center;
    gap: 2px;
    font-size: 0.56rem;
    color: #2E7D32;
    background: #E8F5E9;
    padding: 1.5px 5px;
    border-radius: 4px;
    font-weight: 700;
    white-space: nowrap;
    line-height: 1.1;
    border: 1px solid rgba(46, 125, 50, 0.2);
}
.pdp-rc-loc-date {
    font-size: 0.64rem;
    color: var(--light-text);
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.pdp-rc-stars {
    color: #F59E0B;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    line-height: 1;
}

.pdp-rc-occasion {
    display: inline-block;
    align-self: flex-start;
    padding: 2px 6px;
    border-radius: 4px;
    background: var(--gold-pale);
    color: var(--dark-gold);
    font-size: 0.6rem;
    font-weight: 800;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}

.pdp-rc-text {
    font-size: 0.78rem;
    color: var(--mid-text);
    line-height: 1.45;
    flex: 1;
}

.pdp-rc-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 6px;
    border-top: 1px solid var(--soft-platinum);
    font-size: 0.68rem;
    color: var(--light-text);
}
.pdp-rc-helpful-btn {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 7px;
    border-radius: 5px;
    border: 1px solid var(--soft-platinum);
    background: #FFFFFF;
    color: var(--mid-text);
    font-size: 0.66rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
}
.pdp-rc-helpful-btn:hover, .pdp-rc-helpful-btn.voted {
    border-color: var(--dark-gold);
    color: var(--dark-gold);
    background: var(--gold-pale);
}

/* Carousel Navigation Arrows */
.pdp-rev-arrow {
    position: absolute;
    top: 45%;
    transform: translateY(-50%);
    width: 32px; height: 32px;
    border-radius: 50%;
    background: rgba(255,255,255,0.95);
    border: 1.5px solid var(--gold-border);
    color: var(--dark-gold);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    z-index: 10;
    transition: all 0.2s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}
.pdp-rev-arrow:hover {
    background: var(--dark-gold);
    color: #FFFFFF;
    transform: translateY(-50%) scale(1.08);
}
.pdp-rev-arrow.prev { left: -14px; }
.pdp-rev-arrow.next { right: -14px; }
.pdp-rev-arrow svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2.4; }

@media (max-width: 900px) {
    .pdp-rev-arrow { display: none; }
}

/* Dot Indicators */
.pdp-rev-dots {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-top: 8px;
}
.pdp-rev-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--soft-platinum);
    cursor: pointer;
    transition: all 0.25s ease;
}
.pdp-rev-dot.active {
    width: 18px;
    border-radius: 8px;
    background: var(--dark-gold);
}

/* ════════════════════════════════════════════════════
   RELATED PRODUCTS SECTION
════════════════════════════════════════════════════ */
/* ════════════════════════════════════════════════════
   RELATED PRODUCTS CAROUSEL ("You May Also Admire")
════════════════════════════════════════════════════ */
.pdp-bottom-section {
    margin-top: clamp(36px, 5vw, 60px);
}
.pdp-section-title-large {
    font-family: var(--font-serif);
    font-size: clamp(1.15rem, 3vw, 1.5rem);
    font-weight: 800;
    color: var(--dark-text);
    letter-spacing: 0.06em;
    text-align: center;
    margin-bottom: 18px;
    position: relative;
}
.pdp-section-title-large::after {
    content: '';
    display: block;
    width: 44px;
    height: 2px;
    background: var(--dark-gold);
    margin: 6px auto 0;
}

.pdp-rel-carousel-wrap {
    position: relative;
    margin-top: 14px;
}
.pdp-rel-track {
    display: flex;
    gap: 12px;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    scrollbar-width: none;
    -webkit-overflow-scrolling: touch;
    padding: 6px 2px 14px;
    touch-action: pan-y pinch-zoom;
    overscroll-behavior-x: contain;
}
.pdp-rel-track::-webkit-scrollbar { display: none; }

/* Product Card - Sleek 2-Show on Mobile, 4-Show on Desktop */
.pdp-rel-card {
    flex: 0 0 220px;
    max-width: 240px;
    scroll-snap-align: start;
    background: #FFFFFF;
    border-radius: 12px;
    border: 1.2px solid var(--soft-platinum);
    overflow: hidden;
    transition: all 0.25s ease;
    display: flex;
    flex-direction: column;
    text-decoration: none;
    color: inherit;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    position: relative;
}
@media (max-width: 767px) {
    .pdp-rel-card {
        flex: 0 0 calc(50% - 6px);
        min-width: 140px;
        max-width: 175px;
        border-radius: 10px;
    }
}
@media (max-width: 360px) {
    .pdp-rel-card {
        flex: 0 0 135px;
        min-width: 135px;
    }
}
.pdp-rel-card:hover {
    border-color: var(--dark-gold);
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(138,104,31,0.14);
}

.pdp-rel-img-wrap {
    aspect-ratio: 3/4;
    overflow: hidden;
    position: relative;
    background: var(--off-white-2);
}
.pdp-rel-img-wrap img {
    width: 100%; height: 100%; object-fit: cover; object-position: top;
    transition: transform 0.35s ease;
}
.pdp-rel-card:hover .pdp-rel-img-wrap img { transform: scale(1.06); }

.pdp-rel-badge {
    position: absolute;
    top: 6px;
    left: 6px;
    background: var(--dark-gold);
    color: #FFFFFF;
    font-size: 0.55rem;
    font-weight: 800;
    padding: 2px 6px;
    border-radius: 4px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    z-index: 2;
}

.pdp-rel-body {
    padding: 8px 10px 10px;
    display: flex;
    flex-direction: column;
    gap: 3px;
    flex: 1;
}
@media (max-width: 600px) {
    .pdp-rel-body {
        padding: 6px 8px 8px;
        gap: 2px;
    }
}
.pdp-rel-cat {
    font-size: 0.58rem;
    font-weight: 800;
    color: var(--dark-gold);
    text-transform: uppercase;
    letter-spacing: 0.08em;
}
.pdp-rel-title {
    font-family: var(--font-serif);
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--dark-text);
    line-height: 1.25;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
@media (max-width: 600px) {
    .pdp-rel-title {
        font-size: 0.74rem;
    }
}

.pdp-rel-price-row {
    display: flex;
    align-items: center;
    gap: 5px;
    margin-top: auto;
    padding-top: 4px;
    flex-wrap: wrap;
}
.pdp-rel-price {
    font-size: 0.85rem;
    font-weight: 900;
    color: var(--dark-gold);
    line-height: 1;
}
@media (max-width: 600px) {
    .pdp-rel-price {
        font-size: 0.8rem;
    }
}
.pdp-rel-mrp {
    font-size: 0.65rem;
    color: var(--light-text);
    text-decoration: line-through;
}
.pdp-rel-disc {
    font-size: 0.58rem;
    font-weight: 800;
    color: #2E7D32;
}

/* Related Navigation Arrows */
.pdp-rel-arrow {
    position: absolute;
    top: 45%;
    transform: translateY(-50%);
    width: 32px; height: 32px;
    border-radius: 50%;
    background: rgba(255,255,255,0.95);
    border: 1.5px solid var(--gold-border);
    color: var(--dark-gold);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    z-index: 10;
    transition: all 0.2s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}
.pdp-rel-arrow:hover {
    background: var(--dark-gold);
    color: #FFFFFF;
    transform: translateY(-50%) scale(1.08);
}
.pdp-rel-arrow.prev { left: -14px; }
.pdp-rel-arrow.next { right: -14px; }
.pdp-rel-arrow svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2.4; }

@media (max-width: 900px) {
    .pdp-rel-arrow { display: none; }
}

/* Related Dots */
.pdp-rel-dots {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-top: 8px;
}
.pdp-rel-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--soft-platinum);
    cursor: pointer;
    transition: all 0.25s ease;
}
.pdp-rel-dot.active {
    width: 18px;
    border-radius: 8px;
    background: var(--dark-gold);
}

/* ════════════════════════════════════════════════════
   SIZE GUIDE MODAL
════════════════════════════════════════════════════ */
.pdp-modal-overlay {
    position: fixed; inset: 0; z-index: 10000;
    background: rgba(0,0,0,0.65);
    backdrop-filter: blur(4px);
    display: none; align-items: center; justify-content: center;
    padding: 16px;
}
.pdp-modal-overlay.open { display: flex; }
.pdp-modal-box {
    background: #FFFFFF;
    border-radius: 16px;
    max-width: 580px; width: 100%;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    overflow: hidden;
    border: 1.5px solid var(--gold-border);
    animation: modalPop 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
}
@keyframes modalPop {
    from { opacity: 0; transform: scale(0.92) translateY(20px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}
.pdp-modal-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 22px; border-bottom: 1.5px solid var(--soft-platinum);
    background: #FAF8F4;
}
.pdp-modal-title {
    font-family: var(--font-serif);
    font-size: 1.1rem;
    font-weight: 800;
    color: var(--dark-gold);
    margin: 0;
}
.pdp-modal-close-btn {
    width: 32px; height: 32px; border-radius: 50%;
    background: #FFFFFF; border: 1px solid var(--soft-platinum);
    font-size: 1.2rem; display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: var(--dark-text);
}
.pdp-modal-body {
    padding: 20px 22px;
    max-height: 75vh;
    overflow-y: auto;
}
.pdp-size-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.8rem;
    text-align: center;
    margin-top: 12px;
}
.pdp-size-table th, .pdp-size-table td {
    padding: 10px 8px;
    border: 1px solid var(--soft-platinum);
}
.pdp-size-table th {
    background: var(--gold-pale);
    color: var(--dark-gold);
    font-weight: 800;
}

/* Toast Container */
.toast-container {
    position: fixed; bottom: 84px; left: 50%;
    transform: translateX(-50%); z-index: 100000;
    display: flex; flex-direction: column; align-items: center; gap: 8px;
    pointer-events: none;
}
.toast {
    padding: 10px 22px; border-radius: 30px;
    background: var(--dark-text); color: var(--off-white);
    font-size: 0.78rem; font-weight: 600; letter-spacing: 0.04em;
    box-shadow: 0 4px 24px rgba(0,0,0,0.22); white-space: nowrap;
    opacity: 0; transform: translateY(8px) scale(0.96); transition: all 0.3s ease;
}
.toast.show { opacity: 1; transform: translateY(0) scale(1); }
</style>
</head>
<body>

<!-- ════════════ HEADER PARTIAL ════════════ -->
<?php include 'singelproduthader.php'; ?>

<!-- ════════════ MAIN PRODUCT DETAIL CONTENT ════════════ -->
<main class="pdp-main-wrapper">
    <div class="pdp-layout-grid">
        
        <!-- ── Left: Interactive Swipeable Gallery ── -->
        <div class="pdp-gallery-column">
            <div class="pdp-gallery-slider" id="pdpGallerySlider">
                <?php if (!empty($product['badge'])): ?>
                <span class="pdp-badge-tag"><?= htmlspecialchars($product['badge']) ?></span>
                <?php endif; ?>

                <button class="pdp-zoom-btn" title="View Fullscreen Image" onclick="openFullscreenImage()">
                    <svg viewBox="0 0 24 24"><polyline points="15 3 21 3 21 9"/><polyline points="9 21 3 21 3 15"/><line x1="21" y1="3" x2="14" y2="10"/><line x1="3" y1="21" x2="10" y2="14"/></svg>
                </button>

                <!-- Navigation Arrows (Desktop) -->
                <button class="pdp-slider-arrow prev" id="pdpSlidePrev" aria-label="Previous image" onclick="slidePdpGallery(-1)">
                    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <button class="pdp-slider-arrow next" id="pdpSlideNext" aria-label="Next image" onclick="slidePdpGallery(1)">
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </button>

                <!-- Swipeable Track -->
                <div class="pdp-slider-track" id="pdpSliderTrack">
                    <?php foreach ($galleryImages as $index => $img): ?>
                    <div class="pdp-slide" data-idx="<?= $index ?>">
                        <img
                            src="<?= htmlspecialchars($img) ?>"
                            alt="<?= htmlspecialchars($product['name']) ?> - View <?= $index + 1 ?>"
                            onError="this.src='https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=800&q=80'"
                        />
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Slide Index Counter -->
                <div class="pdp-slide-counter" id="pdpSlideCounter">1 / <?= count($galleryImages) ?></div>
            </div>

            <!-- Multi-Photo Thumbnails -->
            <div class="pdp-thumbnails-strip" id="pdpThumbnailsStrip">
                <?php foreach ($galleryImages as $index => $img): ?>
                <div class="pdp-thumb-item <?= $index === 0 ? 'active' : '' ?>" data-idx="<?= $index ?>" onclick="goToSlide(<?= $index ?>)">
                    <img src="<?= htmlspecialchars($img) ?>" alt="Thumb <?= $index + 1 ?>" onError="this.src='https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=200&q=80'" />
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- ── Right: Product Details & Conversion Actions ── -->
        <div class="pdp-details-column">
            <div>
                <span class="pdp-brand-tag">KALANIKETAN ETHNIC LUXURY</span>
                <h1 class="pdp-title"><?= htmlspecialchars($product['name']) ?></h1>
            </div>

            <!-- Rating Row -->
            <div class="pdp-rating-row">
                <div class="pdp-rating-pill">
                    <span>★ <?= number_format($product['rating'], 1) ?></span>
                </div>
                <span class="pdp-review-count"><?= $product['reviews'] ?> Verified Reviews</span>
                <span class="pdp-sku-badge">SKU: <?= htmlspecialchars($product['sku']) ?></span>
            </div>

            <!-- Price Card -->
            <div class="pdp-price-card">
                <div class="pdp-price-main-row">
                    <span class="pdp-price-val">₹<?= number_format($product['price']) ?></span>
                    <?php if (!empty($product['old_price'])): ?>
                    <span class="pdp-mrp-val">MRP ₹<?= number_format($product['old_price']) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($product['discount'])): ?>
                    <span class="pdp-discount-badge"><?= $product['discount'] ?>% OFF</span>
                    <?php endif; ?>
                </div>
                <!-- Animated Luxury Perks Strip -->
                <div class="pdp-animated-perks-strip">
                    <div class="pdp-perk-badge pdp-perk-quality">
                        <svg viewBox="0 0 24 24" class="pdp-perk-svg pulse" fill="currentColor"><path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5zm14 3c0 .6-.4 1-1 1H6c-.6 0-1-.4-1-1v-1h14v1z"/></svg>
                        <span class="pdp-perk-text">Premium Quality</span>
                    </div>
                    <div class="pdp-perk-badge pdp-perk-tax">
                        <svg viewBox="0 0 24 24" class="pdp-perk-svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                        <span class="pdp-perk-text">Exclusive of all taxes</span>
                    </div>
                    <div class="pdp-perk-badge pdp-perk-delivery">
                        <svg viewBox="0 0 24 24" class="pdp-perk-svg flash" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        <span class="pdp-perk-text">Fast Express Delivery</span>
                    </div>
                    <div class="pdp-perk-badge pdp-perk-exchange">
                        <svg viewBox="0 0 24 24" class="pdp-perk-svg spin" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
                        <span class="pdp-perk-text">7-Day Fast Exchange</span>
                    </div>
                </div>
            </div>

            <!-- Colour Swatches -->
            <div>
                <div class="pdp-section-header">
                    <span>SELECT COLOUR: <strong class="pdp-selected-txt" id="pdpSelectedColorName"><?= htmlspecialchars($product['colors'][0] ?? 'Standard') ?></strong></span>
                </div>
                <div class="pdp-color-swatches" id="pdpColorSwatches">
                    <?php foreach ($product['colors'] as $idx => $c): ?>
                    <?php $hex = $colorHex[$c] ?? '#8A681F'; ?>
                    <button
                        class="pdp-color-btn <?= $idx === 0 ? 'active' : '' ?>"
                        data-color="<?= htmlspecialchars($c) ?>"
                        style="background-color: <?= $hex ?>;"
                        title="<?= htmlspecialchars($c) ?>"
                        onclick="selectPdpColor(this)"
                    ></button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Size Selector -->
            <div>
                <div class="pdp-section-header">
                    <span>SELECT SIZE</span>
                    <span class="pdp-size-guide-link" onclick="openSizeGuideModal()">📏 View Size Chart</span>
                </div>
                <div class="pdp-size-grid" id="pdpSizeGrid">
                    <?php foreach ($product['size'] as $idx => $s): ?>
                    <button class="pdp-size-btn <?= $idx === 0 ? 'active' : '' ?>" data-size="<?= htmlspecialchars($s) ?>" onclick="selectPdpSize(this)">
                        <?= htmlspecialchars($s) ?>
                    </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Actions (Quantity, Add to Bag, Buy Now) -->
            <div class="pdp-actions-container">
                <div class="pdp-qty-row">
                    <span style="font-size:0.75rem; font-weight:800; text-transform:uppercase; letter-spacing:0.06em;">Quantity:</span>
                    <div class="pdp-qty-box">
                        <button class="pdp-qty-btn" onclick="updatePdpQty(-1)">−</button>
                        <span class="pdp-qty-num" id="pdpQtyVal">1</span>
                        <button class="pdp-qty-btn" onclick="updatePdpQty(1)">+</button>
                    </div>
                </div>

                <div class="pdp-btn-row">
                    <button class="pdp-atc-btn" onclick="handlePdpAddToCart()">
                        <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                        <span>Add To Bag</span>
                    </button>

                    <button class="pdp-buy-btn" onclick="handlePdpBuyNow()">
                        <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        <span>Buy Now</span>
                    </button>
                </div>

                <!-- Direct WhatsApp Order -->
                <a
                    href="https://api.whatsapp.com/send?phone=919876543210&text=<?= urlencode('Hello Kalaniketan! I would like to order ' . $product['name'] . ' (₹' . number_format($product['price']) . '). Link: https://kalaniketan.in/singelprodut.php?id=' . $product['id']) ?>"
                    target="_blank"
                    class="pdp-wa-order-btn"
                    rel="noopener"
                >
                    <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                    <span>Instant Order via WhatsApp</span>
                </a>
            </div>

            <!-- Pincode Delivery Estimator -->
            <div class="pdp-delivery-box">
                <div class="pdp-del-title">
                    <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    <span>Check Estimated Delivery & COD</span>
                </div>
                <div class="pdp-pincode-input-row">
                    <input type="text" id="pdpPincodeInput" class="pdp-pincode-input" placeholder="Enter 6-digit Pincode (e.g. 395002)" maxlength="6" />
                    <button class="pdp-pincode-btn" onclick="checkPincodeDelivery()">Check</button>
                </div>
                <div class="pdp-pincode-result" id="pdpPincodeResult"></div>
            </div>

            <!-- Accordion Details & Specifications -->
            <div class="pdp-accordion-wrap">
                <!-- 1. Product Details (Myntra Style) -->
                <div class="pdp-acc-item open">
                    <button type="button" class="pdp-acc-header" onclick="togglePdpAcc(this)" aria-expanded="true">
                        <div class="pdp-acc-title-group">
                            <div class="pdp-acc-icon-box">
                                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                            </div>
                            <span class="pdp-acc-title-text">Product Details</span>
                        </div>
                        <div class="pdp-acc-chevron-wrap">
                            <svg viewBox="0 0 24 24" class="pdp-acc-chevron"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </button>
                    <div class="pdp-acc-body">
                        <div class="pdp-myntra-details-wrap">
                            <!-- Design Details -->
                            <div class="pdp-myntra-section-block">
                                <h4 class="pdp-myntra-heading">Design Details</h4>
                                <div class="pdp-myntra-list">
                                    <?php foreach ($currentDetails['design_lines'] as $line): ?>
                                    <div class="pdp-myntra-list-item"><?= htmlspecialchars($line) ?></div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Size & Fit -->
                            <div class="pdp-myntra-section-block">
                                <h4 class="pdp-myntra-heading">Size & Fit</h4>
                                <div class="pdp-myntra-list">
                                    <?php foreach ($currentDetails['size_fit'] as $sf): ?>
                                    <div class="pdp-myntra-list-item"><?= htmlspecialchars($sf) ?></div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Material & Care -->
                            <div class="pdp-myntra-section-block">
                                <h4 class="pdp-myntra-heading">Material & Care</h4>
                                <div class="pdp-myntra-list">
                                    <?php foreach ($currentDetails['material_care'] as $mc): ?>
                                    <div class="pdp-myntra-list-item"><?= htmlspecialchars($mc) ?></div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Specifications -->
                <div class="pdp-acc-item">
                    <button type="button" class="pdp-acc-header" onclick="togglePdpAcc(this)" aria-expanded="false">
                        <div class="pdp-acc-title-group">
                            <div class="pdp-acc-icon-box">
                                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                            </div>
                            <span class="pdp-acc-title-text">Fabric & Garment Specifications</span>
                        </div>
                        <div class="pdp-acc-chevron-wrap">
                            <svg viewBox="0 0 24 24" class="pdp-acc-chevron"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </button>
                    <div class="pdp-acc-body">
                        <div class="pdp-myntra-spec-grid">
                            <?php foreach ($currentSpecs as $spec): ?>
                            <div class="pdp-myntra-spec-cell">
                                <span class="pdp-myntra-spec-title"><?= htmlspecialchars($spec['title']) ?></span>
                                <span class="pdp-myntra-spec-val"><?= htmlspecialchars($spec['val']) ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- 3. Fast Delivery, 100% Original & Fast Exchange -->
                <div class="pdp-acc-item">
                    <button type="button" class="pdp-acc-header" onclick="togglePdpAcc(this)" aria-expanded="false">
                        <div class="pdp-acc-title-group">
                            <div class="pdp-acc-icon-box">
                                <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                            </div>
                            <span class="pdp-acc-title-text">Fast Delivery, 100% Original & Fast Exchange</span>
                        </div>
                        <div class="pdp-acc-chevron-wrap">
                            <svg viewBox="0 0 24 24" class="pdp-acc-chevron"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </button>
                    <div class="pdp-acc-body">
                        <div class="pdp-trust-cards-list">
                            <div class="pdp-trust-mini-card gold">
                                <div class="pdp-trust-mini-icon">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5zm14 3c0 .6-.4 1-1 1H6c-.6 0-1-.4-1-1v-1h14v1z"/></svg>
                                </div>
                                <div class="pdp-trust-mini-text">
                                    <h5>100% Original Certified Handloom</h5>
                                    <p>Authentic ethnic couture directly sourced from Kalaniketan master weavers with silk authenticity guarantee.</p>
                                </div>
                            </div>
                            <div class="pdp-trust-mini-card green">
                                <div class="pdp-trust-mini-icon">
                                    <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                                </div>
                                <div class="pdp-trust-mini-text">
                                    <h5>⚡ Fast Express Priority Dispatch</h5>
                                    <p>Dispatched within 24–48 hours with live SMS/WhatsApp shipment tracking across 19,000+ Indian pincodes.</p>
                                </div>
                            </div>
                            <div class="pdp-trust-mini-card blue">
                                <div class="pdp-trust-mini-icon">
                                    <svg viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
                                </div>
                                <div class="pdp-trust-mini-text">
                                    <h5>💎 7-Day Fast Doorstep Exchange</h5>
                                    <p>Zero-hassle size or fit exchanges arranged instantly with doorstep pickup via our dedicated WhatsApp concierge.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- ════ CUSTOMER REVIEWS & RATINGS BREAKDOWN ════ -->
    <section class="pdp-reviews-section" id="pdpReviewsSection">
        <h2 class="pdp-section-title-large">Verified Customer Reviews</h2>
        
        <div class="pdp-rev-header-grid">
            <div class="pdp-overall-score">
                <div class="pdp-big-rating"><?= number_format($product['rating'], 1) ?></div>
                <div class="pdp-big-stars">★★★★★</div>
                <div class="pdp-score-sub">Based on <?= $product['reviews'] ?> verified buyer reviews</div>
            </div>

            <div class="pdp-bars-wrap">
                <div class="pdp-bar-row"><span>5 Star</span><div class="pdp-bar-track"><div class="pdp-bar-fill" style="width: 88%;"></div></div><span>88%</span></div>
                <div class="pdp-bar-row"><span>4 Star</span><div class="pdp-bar-track"><div class="pdp-bar-fill" style="width: 9%;"></div></div><span>9%</span></div>
                <div class="pdp-bar-row"><span>3 Star</span><div class="pdp-bar-track"><div class="pdp-bar-fill" style="width: 2%;"></div></div><span>2%</span></div>
                <div class="pdp-bar-row"><span>2 Star</span><div class="pdp-bar-track"><div class="pdp-bar-fill" style="width: 1%;"></div></div><span>1%</span></div>
                <div class="pdp-bar-row"><span>1 Star</span><div class="pdp-bar-track"><div class="pdp-bar-fill" style="width: 0%;"></div></div><span>0%</span></div>
            </div>

            <div style="display:flex; flex-direction:column; gap:10px; align-items:flex-end;">
                <button class="pdp-write-rev-btn" onclick="openWriteReviewModal()">
                    <span>✍️ Write a Review</span>
                </button>
            </div>
        </div>

        <!-- Auto-Sliding Carousel Wrapper -->
        <div class="pdp-reviews-carousel-wrap" id="pdpRevCarouselWrap">
            <button class="pdp-rev-arrow prev" id="pdpRevPrev" aria-label="Previous review" onclick="slidePdpReviews(-1)">
                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <button class="pdp-rev-arrow next" id="pdpRevNext" aria-label="Next review" onclick="slidePdpReviews(1)">
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </button>

            <div class="pdp-reviews-track" id="pdpReviewsTrack">
                <?php foreach ($customerReviews as $idx => $rev): ?>
                <?php 
                $initial = strtoupper(substr($rev['name'], 0, 1));
                ?>
                <article class="pdp-review-card" data-rating="<?= $rev['rating'] ?>">
                    <div class="pdp-rc-top">
                        <div class="pdp-rc-avatar"><?= $initial ?></div>
                        <div class="pdp-rc-meta">
                            <div class="pdp-rc-name">
                                <span><?= htmlspecialchars($rev['name']) ?></span>
                            </div>
                            <span class="pdp-rc-loc-date"><?= htmlspecialchars($rev['city']) ?> • <?= htmlspecialchars($rev['date']) ?></span>
                        </div>
                        <div class="pdp-rc-rating-right">
                            <span class="pdp-verified-badge">✓ Verified</span>
                            <div class="pdp-rc-stars"><?= str_repeat('★', $rev['rating']) ?></div>
                        </div>
                    </div>

                    <?php if (!empty($rev['occasion'])): ?>
                    <span class="pdp-rc-occasion">✨ <?= htmlspecialchars($rev['occasion']) ?></span>
                    <?php endif; ?>

                    <p class="pdp-rc-text">
                        "<?= htmlspecialchars($rev['text']) ?>"
                    </p>

                    <div class="pdp-rc-bottom">
                        <span>Helpful?</span>
                        <button class="pdp-rc-helpful-btn" onclick="toggleHelpful(this, <?= (int)$rev['helpful'] ?>)">
                            <span>👍</span>
                            <span>(<?= (int)$rev['helpful'] ?>)</span>
                        </button>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>

            <!-- Dots -->
            <div class="pdp-rev-dots" id="pdpRevDots"></div>
        </div>
    </section>

    <!-- ════ RELATED PRODUCTS CAROUSEL ════ -->
    <section class="pdp-bottom-section" id="pdpRelatedSection">
        <h2 class="pdp-section-title-large">You May Also Admire</h2>

        <div class="pdp-rel-carousel-wrap" id="pdpRelCarouselWrap">
            <!-- Navigation Arrows (Desktop) -->
            <button class="pdp-rel-arrow prev" id="pdpRelPrev" aria-label="Previous related products" onclick="slidePdpRelated(-1)">
                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <button class="pdp-rel-arrow next" id="pdpRelNext" aria-label="Next related products" onclick="slidePdpRelated(1)">
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </button>

            <!-- Scrollable Track (2-show on mobile) -->
            <div class="pdp-rel-track" id="pdpRelTrack">
                <?php 
                $relatedItems = array_filter($products, function($it) use ($product) { return $it['id'] !== $product['id']; });
                foreach ($relatedItems as $rel):
                ?>
                <a href="singelprodut.php?id=<?= $rel['id'] ?>" class="pdp-rel-card">
                    <div class="pdp-rel-img-wrap">
                        <?php if (!empty($rel['badge'])): ?>
                        <span class="pdp-rel-badge"><?= htmlspecialchars($rel['badge']) ?></span>
                        <?php endif; ?>
                        <img src="<?= htmlspecialchars($rel['image']) ?>" alt="<?= htmlspecialchars($rel['name']) ?>" onError="this.src='https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=400&q=80'" loading="lazy" />
                    </div>
                    <div class="pdp-rel-body">
                        <span class="pdp-rel-cat"><?= htmlspecialchars($rel['category']) ?></span>
                        <h3 class="pdp-rel-title"><?= htmlspecialchars($rel['name']) ?></h3>
                        <div class="pdp-rel-price-row">
                            <span class="pdp-rel-price">₹<?= number_format($rel['price']) ?></span>
                            <?php if (!empty($rel['old_price'])): ?>
                            <span class="pdp-rel-mrp">₹<?= number_format($rel['old_price']) ?></span>
                            <?php endif; ?>
                            <?php if (!empty($rel['discount'])): ?>
                            <span class="pdp-rel-disc"><?= $rel['discount'] ?>% OFF</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- Dots -->
            <div class="pdp-rel-dots" id="pdpRelDots"></div>
        </div>
    </section>
</main>

<!-- ════ SIZE GUIDE MODAL ════ -->
<div class="pdp-modal-overlay" id="pdpSizeChartModal" role="dialog" aria-modal="true" aria-label="Size Guide">
    <div class="pdp-modal-box">
        <div class="pdp-modal-header">
            <h3 class="pdp-modal-title">📏 Royal Size & Measurement Guide</h3>
            <button class="pdp-modal-close-btn" onclick="closeSizeGuideModal()">&times;</button>
        </div>
        <div class="pdp-modal-body">
            <p style="font-size:0.8rem; color:var(--mid-text); line-height:1.5;">
                All measurements are tailored with standard Indian ethnic comfort allowances. Custom sizing adjustments can also be requested via our WhatsApp stylist.
            </p>
            <table class="pdp-size-table">
                <thead>
                    <tr>
                        <th>Size</th>
                        <th>Bust (Inches)</th>
                        <th>Waist (Inches)</th>
                        <th>Hip (Inches)</th>
                        <th>Garment Length</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>XS</strong></td><td>32" - 34"</td><td>26" - 28"</td><td>36"</td><td>Standard 54"</td></tr>
                    <tr><td><strong>S</strong></td><td>34" - 36"</td><td>28" - 30"</td><td>38"</td><td>Standard 54"</td></tr>
                    <tr><td><strong>M</strong></td><td>36" - 38"</td><td>30" - 32"</td><td>40"</td><td>Standard 55"</td></tr>
                    <tr><td><strong>L</strong></td><td>38" - 40"</td><td>32" - 34"</td><td>42"</td><td>Standard 55"</td></tr>
                    <tr><td><strong>XL</strong></td><td>40" - 42"</td><td>34" - 36"</td><td>44"</td><td>Standard 56"</td></tr>
                    <tr><td><strong>Free Size</strong></td><td>34" - 44"</td><td>Adjustable</td><td>Free</td><td>Saree 5.5m + 0.8m Blouse</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ════ WRITE A REVIEW MODAL ════ -->
<div class="pdp-modal-overlay" id="pdpWriteReviewModal" role="dialog" aria-modal="true" aria-label="Write a Review">
    <div class="pdp-modal-box" style="max-width: 520px;">
        <div class="pdp-modal-header">
            <h3 class="pdp-modal-title">✍️ Write a Customer Review</h3>
            <button class="pdp-modal-close-btn" onclick="closeWriteReviewModal()">&times;</button>
        </div>
        <div class="pdp-modal-body">
            <form id="pdpReviewForm" onsubmit="submitCustomerReview(event)" style="display:flex; flex-direction:column; gap:14px;">
                <div>
                    <label style="font-size:0.75rem; font-weight:800; text-transform:uppercase; color:var(--dark-text); display:block; margin-bottom:6px;">Your Overall Rating</label>
                    <div id="pdpStarRatingSelector" style="display:flex; gap:6px; font-size:1.6rem; color:#F59E0B; cursor:pointer;">
                        <span data-val="1" onclick="setReviewRating(1)">★</span>
                        <span data-val="2" onclick="setReviewRating(2)">★</span>
                        <span data-val="3" onclick="setReviewRating(3)">★</span>
                        <span data-val="4" onclick="setReviewRating(4)">★</span>
                        <span data-val="5" onclick="setReviewRating(5)">★</span>
                    </div>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; text-transform:uppercase; color:var(--dark-text); display:block; margin-bottom:4px;">Full Name *</label>
                    <input type="text" id="revName" required placeholder="e.g. Radhika Sharma" style="width:100%; height:40px; border:1.5px solid var(--soft-platinum); border-radius:8px; padding:0 12px; font-family:var(--font-sans); font-size:0.85rem;" />
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; text-transform:uppercase; color:var(--dark-text); display:block; margin-bottom:4px;">City / State</label>
                        <input type="text" id="revCity" placeholder="e.g. Mumbai, MH" style="width:100%; height:40px; border:1.5px solid var(--soft-platinum); border-radius:8px; padding:0 12px; font-family:var(--font-sans); font-size:0.85rem;" />
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; text-transform:uppercase; color:var(--dark-text); display:block; margin-bottom:4px;">Occasion Worn</label>
                        <input type="text" id="revOccasion" placeholder="e.g. Wedding Sangeet" style="width:100%; height:40px; border:1.5px solid var(--soft-platinum); border-radius:8px; padding:0 12px; font-family:var(--font-sans); font-size:0.85rem;" />
                    </div>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; text-transform:uppercase; color:var(--dark-text); display:block; margin-bottom:4px;">Your Review Narrative *</label>
                    <textarea id="revText" required rows="3" placeholder="Describe the silk fabric texture, zari brilliance, fitting, and packaging..." style="width:100%; border:1.5px solid var(--soft-platinum); border-radius:8px; padding:10px 12px; font-family:var(--font-sans); font-size:0.85rem; resize:vertical;"></textarea>
                </div>

                <button type="submit" class="pdp-buy-btn" style="width:100%; padding:12px; border-radius:8px; font-size:0.82rem;">Submit Verified Review</button>
            </form>
        </div>
    </div>
</div>

<!-- ════ TOAST CONTAINER ════ -->
<div class="toast-container" id="toastContainer" aria-live="assertive" aria-atomic="true"></div>

<!-- ════ FOOTER PARTIAL ════ -->
<?php include 'singelprodutbottomfotoer.php'; ?>

<!-- ════ CART DRAWER PARTIAL ════ -->
<?php include 'cart.php'; ?>

<!-- ════ WISHLIST DRAWER PARTIAL ════ -->
<?php include 'wishlist.php'; ?>

<!-- ════ CHECKOUT MODAL PARTIAL ════ -->
<?php include 'checkout.php'; ?>

<!-- ════ SCRIPT ENGINE ════ -->
<script>
(function() {
    'use strict';

    var currentProduct = <?= json_encode($product) ?>;
    window.currentPdpProduct = currentProduct;

    // Toast helper
    window.showToast = function(msg) {
        var c = document.getElementById('toastContainer');
        if (!c) return;
        var t = document.createElement('div');
        t.className = 'toast';
        t.textContent = msg;
        c.appendChild(t);
        requestAnimationFrame(function() {
            requestAnimationFrame(function() { t.classList.add('show'); });
        });
        setTimeout(function() {
            t.classList.remove('show');
            setTimeout(function() { t.remove(); }, 350);
        }, 2200);
    };

    // Gallery Slider Controls
    var track = document.getElementById('pdpSliderTrack');
    var counter = document.getElementById('pdpSlideCounter');
    var totalSlides = <?= count($galleryImages) ?>;
    var currentSlideIdx = 0;

    window.goToSlide = function(idx) {
        if (!track) return;
        currentSlideIdx = idx;
        var width = track.clientWidth;
        track.scrollTo({ left: idx * width, behavior: 'smooth' });
        updateActiveThumbnail(idx);
        if (counter) counter.textContent = (idx + 1) + ' / ' + totalSlides;
    };

    window.slidePdpGallery = function(delta) {
        var next = currentSlideIdx + delta;
        if (next < 0) next = totalSlides - 1;
        if (next >= totalSlides) next = 0;
        window.goToSlide(next);
    };

    function updateActiveThumbnail(idx) {
        document.querySelectorAll('.pdp-thumb-item').forEach(function(item, i) {
            item.classList.toggle('active', i === idx);
        });
    }

    // Touch Swipe scroll sync listener for Main Gallery
    if (track) {
        track.addEventListener('scroll', function() {
            var width = track.clientWidth;
            if (width > 0) {
                var idx = Math.round(track.scrollLeft / width);
                if (idx !== currentSlideIdx && idx >= 0 && idx < totalSlides) {
                    currentSlideIdx = idx;
                    updateActiveThumbnail(idx);
                    if (counter) counter.textContent = (idx + 1) + ' / ' + totalSlides;
                }
            }
        }, { passive: true });
    }

    // Color Selector
    window.selectPdpColor = function(btn) {
        document.querySelectorAll('.pdp-color-btn').forEach(function(b) { b.classList.remove('active'); });
        btn.classList.add('active');
        var nameEl = document.getElementById('pdpSelectedColorName');
        if (nameEl) nameEl.textContent = btn.dataset.color;
    };

    // Size Selector
    window.selectPdpSize = function(btn) {
        document.querySelectorAll('.pdp-size-btn').forEach(function(b) { b.classList.remove('active'); });
        btn.classList.add('active');
    };

    // Quantity Counter
    var currentQty = 1;
    window.updatePdpQty = function(delta) {
        currentQty += delta;
        if (currentQty < 1) currentQty = 1;
        if (currentQty > 10) currentQty = 10;
        var qEl = document.getElementById('pdpQtyVal');
        if (qEl) qEl.textContent = currentQty;
    };

    // Accordion Toggle
    window.togglePdpAcc = function(headerBtn) {
        var parentItem = headerBtn.closest('.pdp-acc-item');
        if (parentItem) {
            var isOpen = parentItem.classList.toggle('open');
            headerBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        }
    };

    // Add To Bag Function (Integrates directly with Cart Drawer)
    window.handlePdpAddToCart = function() {
        var activeSizeBtn = document.querySelector('.pdp-size-btn.active');
        var selSize = activeSizeBtn ? activeSizeBtn.dataset.size : (currentProduct.size[0] || 'Free Size');

        var activeColorBtn = document.querySelector('.pdp-color-btn.active');
        var selColor = activeColorBtn ? activeColorBtn.dataset.color : (currentProduct.colors[0] || 'Standard');

        if (typeof window.addToCart === 'function') {
            for (var i = 0; i < currentQty; i++) {
                window.addToCart(currentProduct, selSize, selColor);
            }
        } else {
            // Local fallback
            try {
                var cart = JSON.parse(localStorage.getItem('kalaniketan_cart') || '[]');
                cart.push({
                    id: currentProduct.id,
                    name: currentProduct.name,
                    price: currentProduct.price,
                    image: currentProduct.image,
                    size: selSize,
                    color: selColor,
                    qty: currentQty
                });
                localStorage.setItem('kalaniketan_cart', JSON.stringify(cart));
            } catch(e) {}
        }

        window.showToast('🛍️ Added ' + currentProduct.name + ' to Bag!');
        if (typeof window.syncPdpHeaderState === 'function') window.syncPdpHeaderState();
        if (typeof window.openCartDrawer === 'function') {
            window.openCartDrawer();
        }
    };

    // Buy Now (Instant Checkout Flow)
    window.handlePdpBuyNow = function() {
        var activeSizeBtn = document.querySelector('.pdp-size-btn.active');
        var selSize = activeSizeBtn ? activeSizeBtn.dataset.size : (currentProduct.size[0] || 'Free Size');

        var activeColorBtn = document.querySelector('.pdp-color-btn.active');
        var selColor = activeColorBtn ? activeColorBtn.dataset.color : (currentProduct.colors[0] || 'Standard');

        if (typeof window.addToCart === 'function') {
            for (var i = 0; i < currentQty; i++) {
                window.addToCart(currentProduct, selSize, selColor);
            }
        }

        if (typeof window.syncPdpHeaderState === 'function') window.syncPdpHeaderState();

        // Close cart drawer if open
        if (typeof window.closeCartDrawer === 'function') {
            window.closeCartDrawer();
        }

        // Open checkout modal directly
        if (typeof window.openCheckout === 'function') {
            setTimeout(function() {
                window.openCheckout();
            }, 80);
        } else {
            window.location.href = 'checkout.php';
        }
    };

    // Wishlist Toggle
    window.handlePdpWishlistClick = function() {
        var wishBtn = document.getElementById('pdpMobWishBtn');
        if (typeof window.toggleWishlistProduct === 'function') {
            var added = window.toggleWishlistProduct(currentProduct);
            if (wishBtn) wishBtn.classList.toggle('active', added);
            window.showToast(added ? '♡ Saved to wishlist' : 'Removed from wishlist');
            if (typeof window.syncPdpHeaderState === 'function') window.syncPdpHeaderState();
        }
    };

    // Pincode Delivery Estimator
    window.checkPincodeDelivery = function() {
        var input = document.getElementById('pdpPincodeInput');
        var res = document.getElementById('pdpPincodeResult');
        if (!input || !res) return;

        var pin = input.value.trim();
        if (pin.length !== 6 || isNaN(pin)) {
            res.style.display = 'block';
            res.style.color = '#D32F2F';
            res.textContent = '⚠️ Please enter a valid 6-digit Indian pincode.';
            return;
        }

        var d = new Date();
        d.setDate(d.getDate() + 3);
        var dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        var monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        var dateString = dayNames[d.getDay()] + ', ' + d.getDate() + ' ' + monthNames[d.getMonth()];

        res.style.display = 'block';
        res.style.color = '#2E7D32';
        res.innerHTML = '✅ <strong>Fast Delivery by ' + dateString + '</strong><br />⚡ Fast Express Delivery • 💎 7-Day Fast Exchange • Cash on Delivery Available for ' + pin;
    };

    // Fullscreen Image Lightbox
    window.openFullscreenImage = function() {
        var activeSlide = document.querySelector('.pdp-slide[data-idx="' + currentSlideIdx + '"] img');
        if (activeSlide) {
            window.open(activeSlide.src, '_blank');
        }
    };

    // Size Guide Modal
    window.openSizeGuideModal = function() {
        var modal = document.getElementById('pdpSizeChartModal');
        if (modal) modal.classList.add('open');
    };
    window.closeSizeGuideModal = function() {
        var modal = document.getElementById('pdpSizeChartModal');
        if (modal) modal.classList.remove('open');
    };

    // Write Review Modal
    var currentSelectedRating = 5;
    window.openWriteReviewModal = function() {
        var modal = document.getElementById('pdpWriteReviewModal');
        if (modal) modal.classList.add('open');
    };
    window.closeWriteReviewModal = function() {
        var modal = document.getElementById('pdpWriteReviewModal');
        if (modal) modal.classList.remove('open');
    };
    window.setReviewRating = function(val) {
        currentSelectedRating = val;
        var stars = document.querySelectorAll('#pdpStarRatingSelector span');
        stars.forEach(function(s, idx) {
            s.style.opacity = (idx < val) ? '1' : '0.3';
        });
    };

    window.submitCustomerReview = function(e) {
        e.preventDefault();
        var name = document.getElementById('revName').value.trim();
        var city = document.getElementById('revCity').value.trim() || 'India';
        var occasion = document.getElementById('revOccasion').value.trim() || 'Festive Celebration';
        var text = document.getElementById('revText').value.trim();

        if (!name || !text) return;

        var track = document.getElementById('pdpReviewsTrack');
        if (track) {
            var card = document.createElement('article');
            card.className = 'pdp-review-card';
            card.dataset.rating = currentSelectedRating;
            card.dataset.hasphoto = '0';
            card.innerHTML = 
                '<div class="pdp-rc-top">' +
                    '<div class="pdp-rc-avatar">' + name.charAt(0).toUpperCase() + '</div>' +
                    '<div class="pdp-rc-meta">' +
                        '<div class="pdp-rc-name">' +
                            '<span>' + name + '</span>' +
                        '</div>' +
                        '<span class="pdp-rc-loc-date">' + city + ' • Just now</span>' +
                    '</div>' +
                    '<div class="pdp-rc-rating-right">' +
                        '<span class="pdp-verified-badge">✓ Verified</span>' +
                        '<div class="pdp-rc-stars">' + '★'.repeat(currentSelectedRating) + '</div>' +
                    '</div>' +
                '</div>' +
                '<span class="pdp-rc-occasion">✨ ' + occasion + '</span>' +
                '<p class="pdp-rc-text">"' + text + '"</p>' +
                '<div class="pdp-rc-bottom">' +
                    '<span>Helpful?</span>' +
                    '<button class="pdp-rc-helpful-btn" onclick="toggleHelpful(this, 1)"><span>👍</span><span>(1)</span></button>' +
                '</div>';
            track.insertBefore(card, track.firstChild);
            track.scrollTo({ left: 0, behavior: 'smooth' });
        }

        window.closeWriteReviewModal();
        window.showToast('✨ Thank you! Your review is now live.');
        document.getElementById('pdpReviewForm').reset();
        window.rebuildReviewDots();
    };

    // Helpful upvote button
    window.toggleHelpful = function(btn, currentCount) {
        if (btn.classList.contains('voted')) return;
        btn.classList.add('voted');
        btn.innerHTML = '<span>👍</span><span>(' + (currentCount + 1) + ')</span>';
        window.showToast('❤️ Thank you for your feedback!');
    };

    // Review Filter Pills
    window.filterReviews = function(type, btn) {
        document.querySelectorAll('.pdp-rev-filter-pill').forEach(function(p) { p.classList.remove('active'); });
        btn.classList.add('active');

        var cards = document.querySelectorAll('.pdp-review-card');
        cards.forEach(function(card) {
            if (type === 'all') {
                card.style.display = 'flex';
            } else if (type === '5') {
                card.style.display = (card.dataset.rating === '5') ? 'flex' : 'none';
            } else if (type === 'photo') {
                card.style.display = (card.dataset.hasphoto === '1') ? 'flex' : 'none';
            }
        });
        window.rebuildReviewDots();
    };

    // ════ AUTO-SLIDER CONTROLLER FOR CUSTOMER REVIEWS ════
    var revTrack = document.getElementById('pdpReviewsTrack');
    var revDotsWrap = document.getElementById('pdpRevDots');
    var revAutoSlideTimer = null;

    window.rebuildReviewDots = function() {
        if (!revDotsWrap || !revTrack) return;
        revDotsWrap.innerHTML = '';
        var visibleCards = Array.from(revTrack.querySelectorAll('.pdp-review-card')).filter(function(c) {
            return c.style.display !== 'none';
        });

        visibleCards.forEach(function(_, idx) {
            var dot = document.createElement('div');
            dot.className = 'pdp-rev-dot ' + (idx === 0 ? 'active' : '');
            dot.onclick = function() {
                var card = visibleCards[idx];
                if (card) {
                    revTrack.scrollTo({ left: card.offsetLeft - revTrack.offsetLeft, behavior: 'smooth' });
                }
            };
            revDotsWrap.appendChild(dot);
        });
    };

    window.slidePdpReviews = function(direction) {
        if (!revTrack) return;
        var firstCard = revTrack.querySelector('.pdp-review-card');
        var cardWidth = firstCard ? (firstCard.clientWidth + 16) : 320;
        
        var maxScroll = revTrack.scrollWidth - revTrack.clientWidth;
        var newLeft = revTrack.scrollLeft + (direction * cardWidth);

        if (newLeft > maxScroll + 10) {
            revTrack.scrollTo({ left: 0, behavior: 'smooth' });
        } else if (newLeft < 0) {
            revTrack.scrollTo({ left: maxScroll, behavior: 'smooth' });
        } else {
            revTrack.scrollTo({ left: newLeft, behavior: 'smooth' });
        }
    };

    function startReviewAutoSlide() {
        if (revAutoSlideTimer) clearInterval(revAutoSlideTimer);
        revAutoSlideTimer = setInterval(function() {
            window.slidePdpReviews(1);
        }, 3800);
    }

    function pauseReviewAutoSlide() {
        if (revAutoSlideTimer) {
            clearInterval(revAutoSlideTimer);
            revAutoSlideTimer = null;
        }
    }

    if (revTrack) {
        window.rebuildReviewDots();
        startReviewAutoSlide();

        // Pause on hover or touch
        var carouselWrap = document.getElementById('pdpRevCarouselWrap');
        if (carouselWrap) {
            carouselWrap.addEventListener('mouseenter', pauseReviewAutoSlide);
            carouselWrap.addEventListener('mouseleave', startReviewAutoSlide);
            carouselWrap.addEventListener('touchstart', pauseReviewAutoSlide, { passive: true });
            carouselWrap.addEventListener('touchend', function() {
                setTimeout(startReviewAutoSlide, 3000);
            }, { passive: true });
        }

        // Sync review dots on scroll
        revTrack.addEventListener('scroll', function() {
            var firstCard = revTrack.querySelector('.pdp-review-card');
            if (!firstCard) return;
            var cardWidth = firstCard.clientWidth + 16;
            var activeIdx = Math.round(revTrack.scrollLeft / cardWidth);
            var dots = document.querySelectorAll('.pdp-rev-dot');
            dots.forEach(function(d, i) {
                d.classList.toggle('active', i === activeIdx);
            });
        }, { passive: true });
    }

    // ════ AUTO-SLIDER CONTROLLER FOR RELATED PRODUCTS ════
    var relTrack = document.getElementById('pdpRelTrack');
    var relDotsWrap = document.getElementById('pdpRelDots');
    var relAutoSlideTimer = null;

    window.rebuildRelDots = function() {
        if (!relDotsWrap || !relTrack) return;
        relDotsWrap.innerHTML = '';
        var cards = relTrack.querySelectorAll('.pdp-rel-card');
        var step = window.innerWidth <= 767 ? 2 : 4;
        var totalDots = Math.ceil(cards.length / step);

        for (var i = 0; i < totalDots; i++) {
            (function(idx) {
                var dot = document.createElement('div');
                dot.className = 'pdp-rel-dot ' + (idx === 0 ? 'active' : '');
                dot.onclick = function() {
                    var targetCard = cards[idx * step] || cards[cards.length - 1];
                    if (targetCard) {
                        relTrack.scrollTo({ left: targetCard.offsetLeft - relTrack.offsetLeft, behavior: 'smooth' });
                    }
                };
                relDotsWrap.appendChild(dot);
            })(i);
        }
    };

    window.slidePdpRelated = function(direction) {
        if (!relTrack) return;
        var firstCard = relTrack.querySelector('.pdp-rel-card');
        var cardWidth = firstCard ? (firstCard.clientWidth + 12) : 200;
        var scrollAmount = cardWidth * (window.innerWidth <= 767 ? 2 : 3);
        
        var maxScroll = relTrack.scrollWidth - relTrack.clientWidth;
        var newLeft = relTrack.scrollLeft + (direction * scrollAmount);

        if (newLeft > maxScroll + 10) {
            relTrack.scrollTo({ left: 0, behavior: 'smooth' });
        } else if (newLeft < 0) {
            relTrack.scrollTo({ left: maxScroll, behavior: 'smooth' });
        } else {
            relTrack.scrollTo({ left: newLeft, behavior: 'smooth' });
        }
    };

    function startRelAutoSlide() {
        if (relAutoSlideTimer) clearInterval(relAutoSlideTimer);
        relAutoSlideTimer = setInterval(function() {
            window.slidePdpRelated(1);
        }, 4500);
    }

    function pauseRelAutoSlide() {
        if (relAutoSlideTimer) {
            clearInterval(relAutoSlideTimer);
            relAutoSlideTimer = null;
        }
    }

    if (relTrack) {
        window.rebuildRelDots();
        startRelAutoSlide();

        var relWrap = document.getElementById('pdpRelCarouselWrap');
        if (relWrap) {
            relWrap.addEventListener('mouseenter', pauseRelAutoSlide);
            relWrap.addEventListener('mouseleave', startRelAutoSlide);
            relWrap.addEventListener('touchstart', pauseRelAutoSlide, { passive: true });
            relWrap.addEventListener('touchend', function() {
                setTimeout(startRelAutoSlide, 3000);
            }, { passive: true });
        }

        // Sync related dots on scroll
        relTrack.addEventListener('scroll', function() {
            var firstCard = relTrack.querySelector('.pdp-rel-card');
            if (!firstCard) return;
            var cardWidth = firstCard.clientWidth + 12;
            var step = window.innerWidth <= 767 ? 2 : 4;
            var activeIdx = Math.round(relTrack.scrollLeft / (cardWidth * step));
            var dots = document.querySelectorAll('.pdp-rel-dot');
            dots.forEach(function(d, i) {
                d.classList.toggle('active', i === activeIdx);
            });
        }, { passive: true });

        window.addEventListener('resize', window.rebuildRelDots, { passive: true });
    }

    // Modal background click dismiss
    var writeRevModal = document.getElementById('pdpWriteReviewModal');
    if (writeRevModal) {
        writeRevModal.addEventListener('click', function(e) {
            if (e.target === writeRevModal) window.closeWriteReviewModal();
        });
    }

    var sizeModal = document.getElementById('pdpSizeChartModal');
    if (sizeModal) {
        sizeModal.addEventListener('click', function(e) {
            if (e.target === sizeModal) window.closeSizeGuideModal();
        });
    }

})();
</script>

<!-- ════════════ SMART WHATSAPP SHARE MODAL (Meesho-Grade Flow) ════════════ -->
<?php include 'smartshare.php'; ?>

</body>
</html>
