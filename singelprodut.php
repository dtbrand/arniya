<?php
/**
 * singelprodut.php — Premium Mobile-First Single Product Page (PDP)
 * Inspired by Luxury E-Commerce / Myntra Experience
 * Features:
 *  1. Product Image Gallery (Auto-Slide + Touch Swipe + Dot/Counter Indicators)
 *  2. Second Image / Key Highlights (Myntra-Style Multi-Image Slider + Specs Grid)
 *  3. Product Information (Dynamic PHP Data, Color Swatches, Size Selector, Quantity)
 *  4. Customer Reviews Carousel (Auto-Slide + Touch Swipe + Star Ratings + Helpful Votes)
 *  5. "You May Also Admire" Related Products Carousel (Auto-Slide + Touch Swipe + Price Badges)
 *  6. Common Reusable Carousel Engine (AgyCarousel)
 *  7. Sticky Mobile Action Bar (Add to Bag | Buy Now | WhatsApp Direct Order)
 *  8. Size Guide Modal, Write Review Modal, and Instant WhatsApp Order Modal
 */

// ── 1. Comprehensive Luxury Product Catalog Database ───────────────────────
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
        'desc'     => 'An exquisite masterpiece from our Royal Heritage edit. The Nilambari Silk Saree features pure gold zari brocade work along the pallu, finished with artisanal floral buttas and rich temple borders.',
        'gallery'  => [
            'images/product1.png',
            'https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=800&q=80'
        ],
        'highlights_images' => [
            ['url' => 'images/product1.png', 'title' => 'Heritage Weave Detail'],
            ['url' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=800&q=80', 'title' => 'Pure Gold Zari Pallu'],
            ['url' => 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?auto=format&fit=crop&w=800&q=80', 'title' => 'Artisanal Border Finish']
        ],
        'key_highlights' => [
            'Fabric'           => 'Pure Kanchipuram Silk',
            'Shape'            => 'Traditional 6-Yard Saree',
            'Pattern / Work'   => 'Pure Gold Zari Floral Jaal',
            'Occasion'         => 'Wedding, Festive & Reception',
            'Border Style'     => 'Double-Wide Contrast Temple Border',
            'Blouse Piece'     => 'Included (0.8m Silk Blend)',
            'Wash Care'        => 'Dry Clean Only',
            'Weave Type'       => 'Handloom Kadhwa Jacquard',
            'Transparency'     => 'Opaque with Lustrous Sheen'
        ]
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
        'desc'     => 'Handwoven in Varanasi using centuries-old kadhwa weaving techniques. Adorned with delicate antique gold floral jaal, this saree exudes regal Indian heritage.',
        'gallery'  => [
            'images/product2.png',
            'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=800&q=80'
        ],
        'highlights_images' => [
            ['url' => 'images/product2.png', 'title' => 'Varanasi Handloom Weave'],
            ['url' => 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?auto=format&fit=crop&w=800&q=80', 'title' => 'Antique Gold Zari Motif'],
            ['url' => 'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=800&q=80', 'title' => 'Katan Silk Texture']
        ],
        'key_highlights' => [
            'Fabric'           => 'Pure Banarasi Katan Silk',
            'Shape'            => 'Traditional 6-Yard Saree',
            'Pattern / Work'   => 'Antique Gold Floral Jaal',
            'Occasion'         => 'Bridal & Royal Gala',
            'Border Style'     => 'Heavy Kadwa Zari Border',
            'Blouse Piece'     => 'Unstitched Katan Silk Piece',
            'Wash Care'        => 'Dry Clean Only',
            'Weave Type'       => 'Handwoven Kadwa Technique',
            'Transparency'     => 'Opaque'
        ]
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
        'desc'     => 'Woven with three-ply twisted silk yarn and dipped in pure metallic gold zari. Features monumental temple gopuram motifs along the double-wide contrast border.',
        'gallery'  => [
            'images/product3.png',
            'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?auto=format&fit=crop&w=800&q=80'
        ],
        'highlights_images' => [
            ['url' => 'images/product3.png', 'title' => 'Gopuram Motif Zoom'],
            ['url' => 'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=800&q=80', 'title' => '3-Ply Silk Weft & Warp'],
            ['url' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=800&q=80', 'title' => 'Rich Contrast Pallu']
        ],
        'key_highlights' => [
            'Fabric'           => 'Pure Mulberry Silk (3-Ply)',
            'Shape'            => 'Traditional 6-Yard Saree',
            'Pattern / Work'   => 'Monumental Temple Gopuram Motifs',
            'Occasion'         => 'Temple Ceremonies & Muhurtham',
            'Border Style'     => 'Contrast Double-Wide Border',
            'Blouse Piece'     => 'Contrast Tissue Blouse Piece',
            'Wash Care'        => 'Specialist Dry Clean Only',
            'Weave Type'       => 'Korvai Interlock Weaving',
            'Transparency'     => 'Opaque'
        ]
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
        'desc'     => 'Lightweight, fluid, and romantic. Decorated with hand-embroidered resham florals and delicate scalloped borders for celebratory evening soirees.',
        'gallery'  => [
            'images/product4.png',
            'https://images.unsplash.com/photo-1595777457583-95e059d581b8?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?auto=format&fit=crop&w=800&q=80'
        ],
        'highlights_images' => [
            ['url' => 'images/product4.png', 'title' => 'Resham Threadwork Floral'],
            ['url' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?auto=format&fit=crop&w=800&q=80', 'title' => 'Scalloped Cutwork Border'],
            ['url' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=800&q=80', 'title' => 'Fluid Drape Sheen']
        ],
        'key_highlights' => [
            'Fabric'           => 'Pure Viscose Georgette',
            'Shape'            => 'Fluid Contemporary Saree',
            'Pattern / Work'   => 'Hand-Embroidered Resham Florals',
            'Occasion'         => 'Evening Soiree, Cocktail & Party',
            'Border Style'     => 'Delicate Scalloped Embroidered Border',
            'Blouse Piece'     => 'Matching Georgette Blouse Piece',
            'Wash Care'        => 'Dry Clean Only',
            'Weave Type'       => 'Artisanal Embroidery',
            'Transparency'     => 'Semi-Sheer'
        ]
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
        'desc'     => 'Flared 32-kali royal floor-length anarkali silhouette with intricate gota patti handwork on the yoke and bell sleeves.',
        'gallery'  => [
            'images/product5.png',
            'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?auto=format&fit=crop&w=800&q=80'
        ],
        'highlights_images' => [
            ['url' => 'images/product5.png', 'title' => 'Gota Patti Yoke Embroidery'],
            ['url' => 'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=800&q=80', 'title' => '32-Kali Flare Volume'],
            ['url' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=800&q=80', 'title' => 'Sheer Organza Dupatta']
        ],
        'key_highlights' => [
            'Fabric'           => 'Chanderi Silk Cotton',
            'Shape'            => 'Flared 32-Kali Anarkali',
            'Pattern / Work'   => 'Authentic Gota Patti & Zari Work',
            'Occasion'         => 'Festive Celebrations & Sangeet',
            'Neckline'         => 'Sweetheart Neck with Bell Sleeves',
            'Set Contains'     => 'Floor-Length Kurti, Churidar & Dupatta',
            'Wash Care'        => 'Dry Clean Only',
            'Weave Type'       => 'Handcrafted Chanderi Weave',
            'Transparency'     => 'Opaque with Sheer Dupatta'
        ]
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
        'desc'     => 'A couture bridal creation featuring 180 hours of meticulous dabka, nakshi, and zardozi bullion embroidery over deep crimson silk, complete with dual dupattas.',
        'gallery'  => [
            'images/product6.png',
            'https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=800&q=80'
        ],
        'highlights_images' => [
            ['url' => 'images/product6.png', 'title' => 'Zardozi & Dabka Craftsmanship'],
            ['url' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=800&q=80', 'title' => '4.5m Grand Gher Flare'],
            ['url' => 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?auto=format&fit=crop&w=800&q=80', 'title' => 'Dual Velvet & Net Dupattas']
        ],
        'key_highlights' => [
            'Fabric'           => 'Pure Raw Silk & Micro-Velvet',
            'Shape'            => 'Royal Flared Silhouette (4.5m Flare)',
            'Pattern / Work'   => 'Dabka, Nakshi & Zardozi Bullion',
            'Occasion'         => 'Royal Wedding & Pheras',
            'Choli Detail'     => 'Heavily Embellished Padded Choli',
            'Dupatta Style'    => 'Dual Dupattas (1 Velvet + 1 Soft Net)',
            'Wash Care'        => 'Specialist Couture Dry Clean Only',
            'Weave Type'       => 'Hand-Bullion Embroidery (180 Hours)',
            'Transparency'     => 'Opaque'
        ]
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
        'desc'     => 'Authentic Bagru hand block printed natural vegetable dyes on airy mulmul cotton. Perfect for daytime cultural gatherings and warm weather celebrations.',
        'gallery'  => [
            'images/product7.png',
            'https://images.unsplash.com/photo-1595777457583-95e059d581b8?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=800&q=80'
        ],
        'highlights_images' => [
            ['url' => 'images/product7.png', 'title' => 'Hand Carved Block Print Motif'],
            ['url' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?auto=format&fit=crop&w=800&q=80', 'title' => '100% Breathable Mulmul Cotton'],
            ['url' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=800&q=80', 'title' => 'Natural Vegetable Dye Sheen']
        ],
        'key_highlights' => [
            'Fabric'           => '100% Organic Mulmul Cotton',
            'Shape'            => 'Airy 6-Yard Saree',
            'Pattern / Work'   => 'Authentic Bagru Hand Block Print',
            'Occasion'         => 'Daytime Festive, Cultural & Casual',
            'Border Style'     => 'Hand-Printed Geometric Zari Edge',
            'Blouse Piece'     => 'Attached Mulmul Cotton Piece',
            'Wash Care'        => 'Gentle Hand Wash in Cold Water',
            'Weave Type'       => 'Artisanal Wooden Block Carving',
            'Transparency'     => 'Semi-Opaque'
        ]
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
        'desc'     => 'Dramatic cape-sleeved indo-western evening gown embellished with swarovski crystals and tone-on-tone pearl embroidery.',
        'gallery'  => [
            'images/product8.png',
            'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=800&q=80'
        ],
        'highlights_images' => [
            ['url' => 'images/product8.png', 'title' => 'Swarovski Crystal Bodice'],
            ['url' => 'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=800&q=80', 'title' => 'Floor-Sweeping Silk Cape'],
            ['url' => 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?auto=format&fit=crop&w=800&q=80', 'title' => 'Tone-on-Tone Pearl Work']
        ],
        'key_highlights' => [
            'Fabric'           => 'Pure Organza & Silk Crepe',
            'Shape'            => 'Floor-Length Indo-Western Gown',
            'Pattern / Work'   => 'Swarovski Crystals & Pearl Beads',
            'Occasion'         => 'Cocktail, Reception & Red Carpet',
            'Sleeve Style'     => 'Dramatic Flowing Cape Sleeves',
            'Inner Lining'     => 'Soft Butter Crepe Lining',
            'Wash Care'        => 'Dry Clean Only',
            'Weave Type'       => 'Couture Hand Embroidery',
            'Transparency'     => 'Opaque with Sheer Cape'
        ]
    ]
];

// Resolve requested product ID (Default to #1)
$pid = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$product = $products[$pid] ?? $products[1];
$galleryImages = $product['gallery'] ?? [$product['image']];
$highlightsImages = $product['highlights_images'] ?? [['url' => $product['image'], 'title' => 'Master Craftsmanship']];

// Color Hex Code Palette
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

// Verified Customer Reviews Dataset
$customerReviews = [
    [
        'id' => 1,
        'name' => 'Priya Sharma',
        'city' => 'Mumbai, MH',
        'rating' => 5,
        'date' => '2 days ago',
        'occasion' => 'Wedding Sangeet',
        'text' => 'The fabric quality and real zari weave is breathtaking! Arrived in luxury royal gift packaging within 3 days to Mumbai. Wore it for my cousin’s sangeet and received endless compliments.',
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
        'helpful' => 31
    ]
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
/* ── Design Tokens ─────────────────────────────────────────── */
:root {
    --off-white:      #F8F6F0;
    --off-white-2:    #F2EFE8;
    --dark-gold:      #8A681F;
    --deep-gold:      #6F5218;
    --gold-accent:    #C5A859;
    --gold-pale:      #FAF3E0;
    --gold-border:    rgba(138, 104, 31, 0.25);
    --gold-glow:      rgba(197, 168, 89, 0.35);
    --soft-platinum:  #E5E3DE;
    --dark-text:      #24211C;
    --mid-text:       #5A5348;
    --light-text:     #9A9490;
    --success-green:  #15803D;
    --font-serif:     'Cinzel', serif;
    --font-sans:      'Inter', sans-serif;
    --transition:     0.28s cubic-bezier(0.4, 0, 0.2, 1);
    --shadow-sm:      0 2px 8px rgba(0,0,0,0.04);
    --shadow-md:      0 8px 24px rgba(138,104,31,0.08);
    --shadow-lg:      0 16px 36px rgba(0,0,0,0.12);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body {
    background: var(--off-white);
    font-family: var(--font-sans);
    color: var(--dark-text);
    -webkit-font-smoothing: antialiased;
    overflow-x: hidden;
    touch-action: pan-y pinch-zoom;
}
img { display: block; max-width: 100%; }
a { text-decoration: none; color: inherit; }
button { font-family: inherit; cursor: pointer; border: none; background: none; }

/* ── Main Layout ───────────────────────────────────────────── */
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

/* ═════════════════════════════════════════════════════════════
   SECTION 1: PRODUCT IMAGE GALLERY (TOP)
═════════════════════════════════════════════════════════════ */
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

/* Main Image Slider Viewport */
.pdp-gallery-slider {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    background: #FAF8F4;
    aspect-ratio: 3 / 3.85;
    max-height: 580px;
    width: 100%;
    margin: 0 auto;
    border: 1px solid var(--gold-border);
    box-shadow: 0 8px 28px rgba(0,0,0,0.06);
    user-select: none;
    touch-action: pan-y pinch-zoom;
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

/* Shared Slider Track Styling (Used across all carousels) */
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

/* Slide Counter Badge */
.pdp-slide-counter {
    position: absolute;
    bottom: 12px;
    right: 12px;
    background: rgba(20, 16, 12, 0.75);
    color: #FFF9EE;
    font-size: 0.70rem;
    font-weight: 800;
    letter-spacing: 0.05em;
    padding: 3px 10px;
    border-radius: 20px;
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    z-index: 10;
    pointer-events: none;
    border: 1px solid rgba(255, 255, 255, 0.18);
}

/* Badge Tag on Image */
.pdp-badge-tag {
    position: absolute;
    top: 12px;
    left: 12px;
    background: var(--dark-gold);
    color: #FFFFFF;
    font-family: var(--font-serif);
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    padding: 4px 10px;
    border-radius: 4px;
    z-index: 10;
    box-shadow: 0 4px 12px rgba(0,0,0,0.18);
    pointer-events: none;
}

/* Fullscreen Zoom Button */
.pdp-zoom-btn {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(4px);
    border: 1px solid var(--gold-border);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--dark-gold);
    z-index: 10;
    cursor: pointer;
    transition: var(--transition);
}
.pdp-zoom-btn:hover {
    background: var(--dark-gold);
    color: #FFFFFF;
    transform: scale(1.08);
}
.pdp-zoom-btn svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2.2; }

/* Navigation Arrows */
.pdp-slider-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(6px);
    border: 1px solid var(--gold-border);
    color: var(--dark-gold);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 12;
    transition: var(--transition);
    box-shadow: 0 4px 14px rgba(0,0,0,0.12);
}
.pdp-slider-arrow:hover {
    background: var(--dark-gold);
    color: #FFFFFF;
    transform: translateY(-50%) scale(1.08);
}
.pdp-slider-arrow.prev { left: 10px; }
.pdp-slider-arrow.next { right: 10px; }
.pdp-slider-arrow svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2.4; }

@media (max-width: 767px) {
    .pdp-slider-arrow { display: none; }
}

/* Pagination Dots */
.pdp-slider-dots {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 6px 0;
}
.pdp-slider-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--soft-platinum);
    cursor: pointer;
    transition: all 0.25s ease;
}
.pdp-slider-dot.active {
    width: 20px;
    border-radius: 8px;
    background: var(--dark-gold);
}

/* Multi-Photo Thumbnails Strip */
.pdp-thumbnails-strip {
    display: flex;
    gap: 8px;
    overflow-x: auto;
    scrollbar-width: none;
    padding: 2px;
}
.pdp-thumbnails-strip::-webkit-scrollbar { display: none; }
.pdp-thumb-item {
    flex: 0 0 68px;
    aspect-ratio: 1;
    border-radius: 8px;
    overflow: hidden;
    border: 2px solid transparent;
    cursor: pointer;
    opacity: 0.7;
    transition: var(--transition);
    background: #FFFFFF;
}
.pdp-thumb-item.active {
    border-color: var(--dark-gold);
    opacity: 1;
    box-shadow: 0 0 0 2px var(--gold-glow);
}
.pdp-thumb-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* ═════════════════════════════════════════════════════════════
   PRODUCT DETAILS & PURCHASE AREA (RIGHT COLUMN)
═════════════════════════════════════════════════════════════ */
.pdp-details-column {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.pdp-brand-tag {
    font-family: var(--font-serif);
    font-size: 0.72rem;
    font-weight: 800;
    color: var(--dark-gold);
    letter-spacing: 0.1em;
    text-transform: uppercase;
}

.pdp-title {
    font-family: var(--font-serif);
    font-size: clamp(1.35rem, 2.8vw, 1.85rem);
    font-weight: 700;
    color: var(--dark-text);
    line-height: 1.25;
    margin-top: 2px;
}

/* Rating Pill */
.pdp-rating-row {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
.pdp-rating-pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: #1B5E20;
    color: #FFFFFF;
    font-size: 0.74rem;
    font-weight: 800;
    padding: 3px 8px;
    border-radius: 4px;
}
.pdp-review-count {
    font-size: 0.78rem;
    color: var(--mid-text);
    font-weight: 600;
}
.pdp-sku-badge {
    margin-left: auto;
    font-size: 0.70rem;
    font-weight: 700;
    color: var(--light-text);
    background: #FAF8F4;
    padding: 2px 8px;
    border-radius: 4px;
    border: 1px solid var(--soft-platinum);
}

/* Price Card */
.pdp-price-card {
    background: #FFFFFF;
    border: 1.5px solid var(--gold-border);
    border-radius: 14px;
    padding: 14px 16px;
    box-shadow: 0 4px 16px rgba(138, 104, 31, 0.05);
}
.pdp-price-main-row {
    display: flex;
    align-items: baseline;
    gap: 10px;
    flex-wrap: wrap;
}
.pdp-price-val {
    font-size: clamp(1.5rem, 3.2vw, 1.95rem);
    font-weight: 900;
    color: var(--dark-gold);
    letter-spacing: -0.02em;
}
.pdp-mrp-val {
    font-size: 0.95rem;
    color: var(--light-text);
    text-decoration: line-through;
    font-weight: 600;
}
.pdp-discount-badge {
    background: #ECFDF5;
    color: var(--success-green);
    border: 1px solid #A7F3D0;
    font-size: 0.74rem;
    font-weight: 800;
    padding: 2px 8px;
    border-radius: 20px;
}
.pdp-tax-line {
    font-size: 0.72rem;
    color: var(--light-text);
    margin-top: 4px;
}
.pdp-tax-line .green { color: var(--success-green); font-weight: 700; }

/* Animated Perks Strip */
.pdp-animated-perks-strip {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
    gap: 6px;
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px dashed var(--soft-platinum);
}
.pdp-perk-badge {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.68rem;
    font-weight: 700;
    color: var(--mid-text);
}
.pdp-perk-svg { width: 14px; height: 14px; color: var(--dark-gold); flex-shrink: 0; }

/* Color Swatches */
.pdp-section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.78rem;
    font-weight: 800;
    color: var(--dark-text);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 8px;
}
.pdp-selected-txt { color: var(--dark-gold); }
.pdp-color-swatches {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}
.pdp-color-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 2.5px solid #FFFFFF;
    box-shadow: 0 0 0 1.5px var(--soft-platinum);
    cursor: pointer;
    transition: var(--transition);
}
.pdp-color-btn.active {
    box-shadow: 0 0 0 2.5px var(--dark-gold);
    transform: scale(1.1);
}

/* Size Selector Grid */
.pdp-size-guide-link {
    color: var(--dark-gold);
    cursor: pointer;
    font-weight: 700;
    text-decoration: underline;
}
.pdp-size-grid {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}
.pdp-size-btn {
    padding: 8px 16px;
    border-radius: 8px;
    border: 1.5px solid var(--soft-platinum);
    background: #FFFFFF;
    font-size: 0.78rem;
    font-weight: 800;
    color: var(--dark-text);
    cursor: pointer;
    transition: var(--transition);
}
.pdp-size-btn:hover {
    border-color: var(--dark-gold);
    color: var(--dark-gold);
}
.pdp-size-btn.active {
    border-color: var(--dark-gold);
    background: var(--dark-gold);
    color: #FFFFFF;
    box-shadow: 0 2px 8px rgba(138,104,31,0.25);
}

/* Actions Box */
.pdp-actions-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.pdp-qty-row {
    display: flex;
    align-items: center;
    gap: 10px;
}
.pdp-qty-box {
    display: inline-flex;
    align-items: center;
    border: 1.5px solid var(--soft-platinum);
    border-radius: 8px;
    background: #FFFFFF;
    overflow: hidden;
}
.pdp-qty-btn {
    width: 32px;
    height: 32px;
    font-size: 1rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--dark-text);
    cursor: pointer;
    transition: var(--transition);
}
.pdp-qty-btn:hover { background: var(--off-white); }
.pdp-qty-num {
    padding: 0 12px;
    font-size: 0.85rem;
    font-weight: 800;
    color: var(--dark-text);
}

.pdp-btn-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}
.pdp-atc-btn, .pdp-buy-btn {
    height: 46px;
    border-radius: 10px;
    font-family: var(--font-sans);
    font-size: 0.82rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
    transition: var(--transition);
}
.pdp-atc-btn {
    border: 2px solid var(--dark-gold);
    background: #FFFFFF;
    color: var(--dark-gold);
}
.pdp-atc-btn:hover {
    background: var(--gold-pale);
}
.pdp-buy-btn {
    background: linear-gradient(135deg, var(--dark-gold) 0%, var(--deep-gold) 100%);
    color: #FFFFFF;
    border: none;
    box-shadow: 0 4px 14px rgba(138,104,31,0.3);
}
.pdp-buy-btn:hover {
    box-shadow: 0 6px 20px rgba(138,104,31,0.4);
    transform: translateY(-1px);
}
.pdp-atc-btn svg, .pdp-buy-btn svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2.2; }

/* Direct WhatsApp Order Button */
.pdp-wa-order-btn {
    width: 100%;
    height: 44px;
    border-radius: 10px;
    background: #25D366;
    color: #FFFFFF;
    font-family: var(--font-sans);
    font-size: 0.82rem;
    font-weight: 800;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 4px 14px rgba(37, 211, 102, 0.25);
    transition: var(--transition);
}
.pdp-wa-order-btn:hover {
    background: #20BA56;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(37, 211, 102, 0.35);
}
.pdp-wa-order-btn svg { width: 19px; height: 19px; stroke: currentColor; fill: none; stroke-width: 2.2; }

/* Pincode Estimator */
.pdp-delivery-box {
    background: #FAF8F4;
    border: 1px solid var(--soft-platinum);
    border-radius: 12px;
    padding: 12px 14px;
}
.pdp-del-title {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.76rem;
    font-weight: 800;
    color: var(--dark-text);
    text-transform: uppercase;
}
.pdp-del-title svg { width: 16px; height: 16px; stroke: var(--dark-gold); fill: none; stroke-width: 2; }
.pdp-pincode-input-row {
    display: flex;
    gap: 8px;
    margin-top: 8px;
}
.pdp-pincode-input {
    flex: 1;
    height: 38px;
    border: 1.5px solid var(--soft-platinum);
    border-radius: 8px;
    padding: 0 12px;
    font-family: var(--font-sans);
    font-size: 0.82rem;
    font-weight: 600;
    outline: none;
    background: #FFFFFF;
}
.pdp-pincode-input:focus { border-color: var(--dark-gold); }
.pdp-pincode-btn {
    padding: 0 16px;
    height: 38px;
    border-radius: 8px;
    background: var(--dark-gold);
    color: #FFFFFF;
    font-size: 0.76rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    cursor: pointer;
}
.pdp-pincode-result {
    font-size: 0.74rem;
    font-weight: 600;
    margin-top: 8px;
    display: none;
    line-height: 1.45;
}

/* ═════════════════════════════════════════════════════════════
   SECTION 2: SECOND IMAGE / KEY HIGHLIGHTS — MYNTRA STYLE
═════════════════════════════════════════════════════════════ */
.pdp-key-highlights-section {
    margin-top: clamp(24px, 4vw, 44px);
    background: #FFFFFF;
    border: 1.5px solid var(--gold-border);
    border-radius: 16px;
    padding: clamp(16px, 3vw, 28px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
}

.pdp-kh-header-wrap {
    margin-bottom: 18px;
    border-bottom: 1px solid var(--soft-platinum);
    padding-bottom: 12px;
}
.pdp-kh-badge {
    font-family: var(--font-serif);
    font-size: 0.68rem;
    font-weight: 800;
    color: var(--dark-gold);
    letter-spacing: 0.1em;
    text-transform: uppercase;
}
.pdp-kh-title {
    font-family: var(--font-serif);
    font-size: clamp(1.15rem, 2.2vw, 1.45rem);
    font-weight: 700;
    color: var(--dark-text);
    margin-top: 2px;
}
.pdp-kh-subtitle {
    font-size: 0.78rem;
    color: var(--mid-text);
    margin-top: 4px;
}

.pdp-kh-layout-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
    align-items: stretch;
}
@media (min-width: 820px) {
    .pdp-kh-layout-grid {
        grid-template-columns: 380px 1fr;
    }
}

/* Key Highlights Independent Image Slider */
.pdp-kh-slider-card {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.pdp-kh-slider-viewport {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    background: #FAF8F4;
    aspect-ratio: 3 / 3.8;
    max-height: 420px;
    border: 1.2px solid var(--gold-border);
    box-shadow: 0 4px 14px rgba(0,0,0,0.04);
    touch-action: pan-y pinch-zoom;
    user-select: none;
}
.pdp-kh-slide-tag {
    position: absolute;
    bottom: 10px;
    left: 10px;
    background: rgba(20, 16, 12, 0.78);
    color: #FFF9EE;
    font-size: 0.68rem;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 6px;
    backdrop-filter: blur(4px);
    z-index: 10;
    pointer-events: none;
}

/* Key Highlights Specifications Grid */
.pdp-kh-specs-card {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background: var(--off-white);
    border-radius: 12px;
    border: 1px solid var(--soft-platinum);
    padding: clamp(14px, 2.5vw, 20px);
}
.pdp-kh-product-summary {
    border-bottom: 1px dashed var(--soft-platinum);
    padding-bottom: 12px;
    margin-bottom: 14px;
}
.pdp-kh-cat {
    font-size: 0.68rem;
    font-weight: 800;
    color: var(--dark-gold);
    text-transform: uppercase;
    letter-spacing: 0.06em;
}
.pdp-kh-prod-name {
    font-family: var(--font-serif);
    font-size: 1.1rem;
    font-weight: 800;
    color: var(--dark-text);
    margin: 2px 0 6px;
}
.pdp-kh-price-line {
    display: flex;
    align-items: baseline;
    gap: 8px;
}
.pdp-kh-price {
    font-size: 1.15rem;
    font-weight: 900;
    color: var(--dark-gold);
}
.pdp-kh-mrp {
    font-size: 0.82rem;
    color: var(--light-text);
    text-decoration: line-through;
}
.pdp-kh-disc {
    font-size: 0.70rem;
    font-weight: 800;
    color: var(--success-green);
    background: #E8F5E9;
    padding: 2px 6px;
    border-radius: 4px;
}

.pdp-kh-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 10px;
}
.pdp-kh-item {
    background: #FFFFFF;
    border: 1px solid var(--soft-platinum);
    border-radius: 8px;
    padding: 10px 12px;
    display: flex;
    flex-direction: column;
    gap: 3px;
    transition: var(--transition);
}
.pdp-kh-item:hover {
    border-color: var(--dark-gold);
    transform: translateY(-1px);
}
.pdp-kh-item-label {
    font-size: 0.68rem;
    font-weight: 700;
    color: var(--light-text);
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.pdp-kh-item-val {
    font-size: 0.82rem;
    font-weight: 800;
    color: var(--dark-text);
    line-height: 1.25;
}

/* ═════════════════════════════════════════════════════════════
   SECTION 4: CUSTOMER REVIEWS CAROUSEL
═════════════════════════════════════════════════════════════ */
.pdp-reviews-section {
    margin-top: clamp(24px, 4vw, 44px);
    background: #FFFFFF;
    border: 1.5px solid var(--gold-border);
    border-radius: 16px;
    padding: clamp(16px, 3vw, 28px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
}

.pdp-section-title-large {
    font-family: var(--font-serif);
    font-size: clamp(1.2rem, 2.5vw, 1.5rem);
    font-weight: 700;
    color: var(--dark-text);
    margin-bottom: 16px;
}

.pdp-rev-header-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 16px;
    padding-bottom: 18px;
    border-bottom: 1px solid var(--soft-platinum);
    align-items: center;
}
@media (min-width: 768px) {
    .pdp-rev-header-grid {
        grid-template-columns: 180px 1fr auto;
    }
}

.pdp-overall-score {
    text-align: center;
    background: var(--off-white);
    border-radius: 12px;
    padding: 14px;
    border: 1px solid var(--soft-platinum);
}
.pdp-big-rating {
    font-size: 2.2rem;
    font-weight: 900;
    color: var(--dark-gold);
    font-family: var(--font-serif);
    line-height: 1;
}
.pdp-big-stars {
    color: #F59E0B;
    font-size: 1.1rem;
    letter-spacing: 2px;
    margin: 4px 0;
}
.pdp-score-sub {
    font-size: 0.68rem;
    color: var(--light-text);
    font-weight: 600;
}

.pdp-bars-wrap {
    display: flex;
    flex-direction: column;
    gap: 5px;
}
.pdp-bar-row {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.72rem;
    font-weight: 700;
    color: var(--mid-text);
}
.pdp-bar-track {
    flex: 1;
    height: 6px;
    background: var(--soft-platinum);
    border-radius: 3px;
    overflow: hidden;
}
.pdp-bar-fill {
    height: 100%;
    background: var(--dark-gold);
    border-radius: 3px;
}

.pdp-write-rev-btn {
    padding: 10px 16px;
    border-radius: 8px;
    border: 1.5px solid var(--dark-gold);
    background: #FFFFFF;
    color: var(--dark-gold);
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    cursor: pointer;
    transition: var(--transition);
}
.pdp-write-rev-btn:hover {
    background: var(--dark-gold);
    color: #FFFFFF;
}

.pdp-reviews-carousel-wrap {
    position: relative;
    margin-top: 18px;
}
.pdp-reviews-track {
    display: flex;
    gap: 12px;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    scrollbar-width: none;
    -webkit-overflow-scrolling: touch;
    padding: 4px 2px 12px;
    overscroll-behavior-x: contain;
    touch-action: pan-y pinch-zoom;
}
.pdp-reviews-track::-webkit-scrollbar { display: none; }

.pdp-review-card {
    flex: 0 0 clamp(260px, 75vw, 320px);
    scroll-snap-align: start;
    background: var(--off-white);
    border-radius: 12px;
    padding: 14px 16px;
    border: 1.2px solid var(--soft-platinum);
    display: flex;
    flex-direction: column;
    gap: 8px;
    transition: var(--transition);
}
.pdp-review-card:hover {
    border-color: var(--dark-gold);
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

.pdp-rc-top {
    display: flex;
    align-items: center;
    gap: 8px;
}
.pdp-rc-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--dark-gold) 0%, var(--deep-gold) 100%);
    color: #FFFFFF;
    font-size: 0.78rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.pdp-rc-meta {
    display: flex;
    flex-direction: column;
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
.pdp-rc-loc-date {
    font-size: 0.66rem;
    color: var(--light-text);
    font-weight: 600;
}
.pdp-rc-rating-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 2px;
}
.pdp-verified-badge {
    font-size: 0.58rem;
    color: var(--success-green);
    background: #E8F5E9;
    padding: 1.5px 5px;
    border-radius: 4px;
    font-weight: 800;
}
.pdp-rc-stars {
    color: #F59E0B;
    font-size: 0.75rem;
    line-height: 1;
}
.pdp-rc-occasion {
    display: inline-block;
    align-self: flex-start;
    padding: 2px 6px;
    border-radius: 4px;
    background: var(--gold-pale);
    color: var(--dark-gold);
    font-size: 0.62rem;
    font-weight: 800;
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
    padding: 3px 8px;
    border-radius: 5px;
    border: 1px solid var(--soft-platinum);
    background: #FFFFFF;
    color: var(--mid-text);
    font-size: 0.72rem;
    font-weight: 700;
    cursor: pointer;
    transition: var(--transition);
}
.pdp-rc-helpful-btn:hover {
    border-color: var(--dark-gold);
    color: var(--dark-gold);
}

/* ═════════════════════════════════════════════════════════════
   SECTION 5: "YOU MAY ALSO ADMIRE" RELATED PRODUCTS
═════════════════════════════════════════════════════════════ */
.pdp-bottom-section {
    margin-top: clamp(24px, 4vw, 44px);
    margin-bottom: 20px;
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
    padding: 4px 2px 14px;
    overscroll-behavior-x: contain;
    touch-action: pan-y pinch-zoom;
}
.pdp-rel-track::-webkit-scrollbar { display: none; }

.pdp-rel-card {
    flex: 0 0 clamp(160px, 44vw, 230px);
    scroll-snap-align: start;
    background: #FFFFFF;
    border-radius: 12px;
    overflow: hidden;
    border: 1.2px solid var(--soft-platinum);
    display: flex;
    flex-direction: column;
    box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    transition: var(--transition);
}
.pdp-rel-card:hover {
    border-color: var(--dark-gold);
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
}
.pdp-rel-img-wrap {
    position: relative;
    width: 100%;
    aspect-ratio: 3 / 3.75;
    background: #FAF8F4;
    overflow: hidden;
}
.pdp-rel-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}
.pdp-rel-card:hover .pdp-rel-img-wrap img {
    transform: scale(1.05);
}
.pdp-rel-badge {
    position: absolute;
    top: 8px;
    left: 8px;
    background: var(--dark-gold);
    color: #FFFFFF;
    font-size: 0.60rem;
    font-weight: 800;
    text-transform: uppercase;
    padding: 2px 6px;
    border-radius: 3px;
}

.pdp-rel-body {
    padding: 10px 12px 12px;
    display: flex;
    flex-direction: column;
    flex: 1;
    gap: 3px;
}
.pdp-rel-cat {
    font-size: 0.62rem;
    font-weight: 800;
    color: var(--light-text);
    text-transform: uppercase;
}
.pdp-rel-title {
    font-family: var(--font-serif);
    font-size: 0.82rem;
    font-weight: 700;
    color: var(--dark-text);
    line-height: 1.3;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.pdp-rel-price-row {
    display: flex;
    align-items: baseline;
    gap: 6px;
    margin-top: auto;
    padding-top: 6px;
}
.pdp-rel-price {
    font-size: 0.92rem;
    font-weight: 900;
    color: var(--dark-gold);
}
.pdp-rel-mrp {
    font-size: 0.72rem;
    color: var(--light-text);
    text-decoration: line-through;
}
.pdp-rel-disc {
    font-size: 0.65rem;
    font-weight: 800;
    color: var(--success-green);
}

/* Modals Overlay */
.pdp-modal-overlay {
    position: fixed; inset: 0; z-index: 1000000;
    background: rgba(0,0,0,0.68);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    display: none; align-items: center; justify-content: center;
    padding: 16px;
}
.pdp-modal-overlay.open { display: flex !important; }
.pdp-modal-box {
    background: #FFFFFF;
    border-radius: 16px;
    max-width: 540px; width: 100%;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    overflow: hidden;
    border: 1.5px solid var(--gold-border);
}
.pdp-modal-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 18px; border-bottom: 1.5px solid var(--soft-platinum);
    background: #FAF8F4;
}
.pdp-modal-title {
    font-family: var(--font-serif);
    font-size: 1.05rem;
    font-weight: 800;
    color: var(--dark-gold);
}
.pdp-modal-close-btn {
    width: 30px; height: 30px; border-radius: 50%;
    background: #FFFFFF; border: 1px solid var(--soft-platinum);
    font-size: 1.1rem; display: flex; align-items: center; justify-content: center;
    cursor: pointer;
}
.pdp-modal-body {
    padding: 18px;
    max-height: 75vh;
    overflow-y: auto;
}
.pdp-size-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.78rem;
    text-align: center;
    margin-top: 10px;
}
.pdp-size-table th, .pdp-size-table td {
    padding: 8px;
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
        
        <!-- ── 1. Left: Product Image Gallery ── -->
        <div class="pdp-gallery-column">
            <div class="pdp-gallery-slider" id="pdpGallerySlider">
                <?php if (!empty($product['badge'])): ?>
                <span class="pdp-badge-tag"><?= htmlspecialchars($product['badge']) ?></span>
                <?php endif; ?>

                <button class="pdp-zoom-btn" title="View Fullscreen Image" onclick="openFullscreenImage()">
                    <svg viewBox="0 0 24 24"><polyline points="15 3 21 3 21 9"/><polyline points="9 21 3 21 3 15"/><line x1="21" y1="3" x2="14" y2="10"/><line x1="3" y1="21" x2="10" y2="14"/></svg>
                </button>

                <!-- Navigation Arrows (Desktop) -->
                <button class="pdp-slider-arrow prev" id="pdpMainSlidePrev" aria-label="Previous image">
                    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <button class="pdp-slider-arrow next" id="pdpMainSlideNext" aria-label="Next image">
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </button>

                <!-- Swipeable Track -->
                <div class="pdp-slider-track" id="pdpMainSliderTrack">
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

                <!-- Slide Counter Badge -->
                <div class="pdp-slide-counter" id="pdpMainSlideCounter">1 / <?= count($galleryImages) ?></div>
            </div>

            <!-- Pagination Dots (Mobile) -->
            <div class="pdp-slider-dots" id="pdpMainSliderDots"></div>

            <!-- Multi-Photo Thumbnails (Desktop & Mobile) -->
            <div class="pdp-thumbnails-strip" id="pdpMainThumbnailsStrip">
                <?php foreach ($galleryImages as $index => $img): ?>
                <div class="pdp-thumb-item <?= $index === 0 ? 'active' : '' ?>" data-idx="<?= $index ?>">
                    <img src="<?= htmlspecialchars($img) ?>" alt="Thumb <?= $index + 1 ?>" onError="this.src='https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=200&q=80'" />
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- ── 2. Right: Product Information & Purchase Bar ── -->
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
                <div class="pdp-tax-line">
                    <span>Inclusive of all taxes</span> • <span class="green">⚡ Fast Delivery in 3–5 Days</span>
                </div>
                
                <!-- Animated Luxury Perks Strip -->
                <div class="pdp-animated-perks-strip">
                    <div class="pdp-perk-badge">
                        <svg viewBox="0 0 24 24" class="pdp-perk-svg" fill="currentColor"><path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5zm14 3c0 .6-.4 1-1 1H6c-.6 0-1-.4-1-1v-1h14v1z"/></svg>
                        <span>100% Handloom</span>
                    </div>
                    <div class="pdp-perk-badge">
                        <svg viewBox="0 0 24 24" class="pdp-perk-svg" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        <span>24-48h Dispatch</span>
                    </div>
                    <div class="pdp-perk-badge">
                        <svg viewBox="0 0 24 24" class="pdp-perk-svg" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
                        <span>7-Day Exchange</span>
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

                <!-- Direct WhatsApp Order Checkout Trigger -->
                <button
                    type="button"
                    class="pdp-wa-order-btn"
                    onclick="openPdpWhatsAppOrderModal()"
                    aria-label="Instant Order via WhatsApp"
                >
                    <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                    <span>Instant Order via WhatsApp</span>
                </button>
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
        </div>
    </div>

    <!-- ════════════ 3. KEY HIGHLIGHTS — MYNTRA STYLE ════════════ -->
    <section class="pdp-key-highlights-section" id="pdpKeyHighlightsSection">
        <div class="pdp-kh-header-wrap">
            <span class="pdp-kh-badge">Product Highlights</span>
            <h2 class="pdp-kh-title">Key Highlights &amp; Craft Details</h2>
            <p class="pdp-kh-subtitle">Handcrafted with traditional weaving techniques and pure authenticity.</p>
        </div>

        <div class="pdp-kh-layout-grid">
            <!-- Left/Top: Independent Key Highlights Multi-Image Slider -->
            <div class="pdp-kh-slider-card">
                <div class="pdp-kh-slider-viewport" id="pdpKeyHighlightsSlider">
                    <button class="pdp-slider-arrow prev" id="pdpKhPrev" aria-label="Previous highlight image">
                        <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </button>
                    <button class="pdp-slider-arrow next" id="pdpKhNext" aria-label="Next highlight image">
                        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>

                    <div class="pdp-slider-track" id="pdpKhTrack">
                        <?php foreach ($highlightsImages as $hIdx => $hImg): ?>
                        <div class="pdp-slide" data-idx="<?= $hIdx ?>">
                            <img src="<?= htmlspecialchars($hImg['url']) ?>" alt="<?= htmlspecialchars($product['name']) ?> - <?= htmlspecialchars($hImg['title']) ?>" loading="lazy" />
                            <div class="pdp-kh-slide-tag"><?= htmlspecialchars($hImg['title']) ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="pdp-slide-counter" id="pdpKhCounter">1 / <?= count($highlightsImages) ?></div>
                </div>
                
                <div class="pdp-slider-dots" id="pdpKhDots"></div>
            </div>

            <!-- Right: Key Highlights Attribute Grid -->
            <div class="pdp-kh-specs-card">
                <div class="pdp-kh-product-summary">
                    <span class="pdp-kh-cat"><?= htmlspecialchars($product['category']) ?></span>
                    <h3 class="pdp-kh-prod-name"><?= htmlspecialchars($product['name']) ?></h3>
                    <div class="pdp-kh-price-line">
                        <span class="pdp-kh-price">₹<?= number_format($product['price']) ?></span>
                        <?php if (!empty($product['old_price'])): ?>
                        <span class="pdp-kh-mrp">₹<?= number_format($product['old_price']) ?></span>
                        <span class="pdp-kh-disc"><?= $product['discount'] ?>% OFF</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="pdp-kh-grid">
                    <?php if (!empty($product['key_highlights'])): ?>
                        <?php foreach ($product['key_highlights'] as $khKey => $khVal): ?>
                        <div class="pdp-kh-item">
                            <span class="pdp-kh-item-label"><?= htmlspecialchars($khKey) ?></span>
                            <span class="pdp-kh-item-val"><?= htmlspecialchars($khVal) ?></span>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════ 4. CUSTOMER REVIEWS CAROUSEL ════════════ -->
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

            <div>
                <button class="pdp-write-rev-btn" onclick="openWriteReviewModal()">
                    <span>✍️ Write a Review</span>
                </button>
            </div>
        </div>

        <!-- Auto-Sliding Carousel Wrapper -->
        <div class="pdp-reviews-carousel-wrap" id="pdpRevCarouselWrap">
            <button class="pdp-slider-arrow prev" id="pdpRevPrev" aria-label="Previous review">
                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <button class="pdp-slider-arrow next" id="pdpRevNext" aria-label="Next review">
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </button>

            <div class="pdp-reviews-track" id="pdpReviewsTrack">
                <?php foreach ($customerReviews as $idx => $rev): ?>
                <?php $initial = strtoupper(substr($rev['name'], 0, 1)); ?>
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

                    <p class="pdp-rc-text">"<?= htmlspecialchars($rev['text']) ?>"</p>

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
            <div class="pdp-slider-dots" id="pdpRevDots"></div>
        </div>
    </section>

    <!-- ════════════ 5. "YOU MAY ALSO ADMIRE" RELATED PRODUCTS ════════════ -->
    <section class="pdp-bottom-section" id="pdpRelatedSection">
        <h2 class="pdp-section-title-large">You May Also Admire</h2>

        <div class="pdp-rel-carousel-wrap" id="pdpRelCarouselWrap">
            <!-- Navigation Arrows (Desktop) -->
            <button class="pdp-slider-arrow prev" id="pdpRelPrev" aria-label="Previous related products">
                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <button class="pdp-slider-arrow next" id="pdpRelNext" aria-label="Next related products">
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </button>

            <!-- Scrollable Track -->
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
            <div class="pdp-slider-dots" id="pdpRelDots"></div>
        </div>
    </section>
</main>

<!-- ════════════ SIZE GUIDE MODAL ════════════ -->
<div class="pdp-modal-overlay" id="pdpSizeChartModal" role="dialog" aria-modal="true" aria-label="Size Guide">
    <div class="pdp-modal-box">
        <div class="pdp-modal-header">
            <h3 class="pdp-modal-title">📏 Royal Size &amp; Measurement Guide</h3>
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

<!-- ════════════ WRITE A REVIEW MODAL ════════════ -->
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

<!-- ════════════ STICKY MOBILE BOTTOM ACTION BAR ════════════ -->
<?php include 'singelprodutbottomfotoer.php'; ?>

<!-- ════════════ SMART WHATSAPP SHARE MODAL ════════════ -->
<?php include 'smartshare.php'; ?>

<!-- ════════════ REUSABLE CAROUSEL ENGINE & INTERACTION SCRIPTS ════════════ -->
<script>
(function() {
    'use strict';

    // Current Product Object
    var currentProduct = <?= json_encode($product) ?>;

    // Toast Notification System
    window.showToast = function(msg) {
        var c = document.querySelector('.toast-container');
        if (!c) {
            c = document.createElement('div');
            c.className = 'toast-container';
            document.body.appendChild(c);
        }
        var t = document.createElement('div');
        t.className = 'toast';
        t.textContent = msg;
        c.appendChild(t);
        requestAnimationFrame(function() { t.classList.add('show'); });
        setTimeout(function() {
            t.classList.remove('show');
            setTimeout(function() { t.remove(); }, 300);
        }, 2800);
    };

    // ═════════════════════════════════════════════════════════════
    // COMMON REUSABLE CAROUSEL / SLIDER CLASS (AgyCarousel)
    // ═════════════════════════════════════════════════════════════
    class AgyCarousel {
        constructor(config) {
            this.container = typeof config.container === 'string' ? document.querySelector(config.container) : config.container;
            if (!this.container) return;

            this.track = config.track ? (typeof config.track === 'string' ? this.container.querySelector(config.track) : config.track) : this.container.querySelector('.pdp-slider-track, .pdp-reviews-track, .pdp-rel-track');
            if (!this.track) return;

            this.slides = Array.from(this.track.children);
            if (!this.slides.length) return;

            this.autoplayInterval = config.autoplayInterval || 4000;
            this.touchThreshold = config.touchThreshold || 40;
            this.dotsWrap = typeof config.dotsWrap === 'string' ? document.querySelector(config.dotsWrap) : config.dotsWrap;
            this.counterEl = typeof config.counterEl === 'string' ? document.querySelector(config.counterEl) : config.counterEl;
            this.prevBtn = typeof config.prevBtn === 'string' ? document.querySelector(config.prevBtn) : config.prevBtn;
            this.nextBtn = typeof config.nextBtn === 'string' ? document.querySelector(config.nextBtn) : config.nextBtn;
            this.thumbnailsWrap = typeof config.thumbnailsWrap === 'string' ? document.querySelector(config.thumbnailsWrap) : config.thumbnailsWrap;
            this.isMultiItem = config.isMultiItem || false;

            this.currentIndex = 0;
            this.timer = null;
            this.isDragging = false;
            this.startX = 0;
            this.startY = 0;
            this.currentX = 0;
            this.currentY = 0;
            this.startScrollLeft = 0;
            this.isTouchHorizontal = false;
            this.resumeTimeout = null;

            this.init();
        }

        init() {
            this.buildDots();
            this.updateUI();
            this.bindEvents();
            this.startAutoplay();
        }

        buildDots() {
            if (!this.dotsWrap) return;
            this.dotsWrap.innerHTML = '';
            
            var totalDots = this.isMultiItem 
                ? Math.ceil(this.slides.length / (window.innerWidth <= 767 ? 1.5 : 3)) 
                : this.slides.length;

            for (var i = 0; i < totalDots; i++) {
                var dot = document.createElement('div');
                dot.className = 'pdp-slider-dot' + (i === 0 ? ' active' : '');
                dot.setAttribute('data-idx', i);
                var self = this;
                dot.onclick = (function(idx) {
                    return function() {
                        self.goTo(idx);
                    };
                })(i);
                this.dotsWrap.appendChild(dot);
            }
        }

        updateUI() {
            // Update counter
            if (this.counterEl) {
                this.counterEl.textContent = (this.currentIndex + 1) + ' / ' + this.slides.length;
            }

            // Update dots
            if (this.dotsWrap) {
                var dots = this.dotsWrap.querySelectorAll('.pdp-slider-dot');
                var totalDots = dots.length;
                var dotIndex = this.isMultiItem ? Math.min(this.currentIndex, totalDots - 1) : this.currentIndex;
                dots.forEach(function(d, i) {
                    d.classList.toggle('active', i === dotIndex);
                });
            }

            // Update thumbnails
            if (this.thumbnailsWrap) {
                var thumbs = this.thumbnailsWrap.querySelectorAll('.pdp-thumb-item');
                var self = this;
                thumbs.forEach(function(t, i) {
                    t.classList.toggle('active', i === self.currentIndex);
                });
            }
        }

        goTo(index) {
            var total = this.slides.length;
            this.currentIndex = ((index % total) + total) % total;
            var targetSlide = this.slides[this.currentIndex];
            if (targetSlide) {
                var targetLeft = targetSlide.offsetLeft - this.track.offsetLeft;
                this.track.scrollTo({ left: targetLeft, behavior: 'smooth' });
            }
            this.updateUI();
        }

        next() {
            this.goTo(this.currentIndex + 1);
        }

        prev() {
            this.goTo(this.currentIndex - 1);
        }

        startAutoplay() {
            var prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (prefersReduced || this.autoplayInterval <= 0) return;

            this.pauseAutoplay();
            var self = this;
            this.timer = setInterval(function() {
                self.next();
            }, this.autoplayInterval);
        }

        pauseAutoplay() {
            if (this.timer) {
                clearInterval(this.timer);
                this.timer = null;
            }
            if (this.resumeTimeout) {
                clearTimeout(this.resumeTimeout);
                this.resumeTimeout = null;
            }
        }

        resumeAutoplayAfterDelay(ms) {
            this.pauseAutoplay();
            var self = this;
            this.resumeTimeout = setTimeout(function() {
                self.startAutoplay();
            }, ms || 3500);
        }

        bindEvents() {
            var self = this;

            // Arrow buttons
            if (this.prevBtn) {
                this.prevBtn.onclick = function(e) {
                    e.preventDefault();
                    self.prev();
                    self.resumeAutoplayAfterDelay();
                };
            }
            if (this.nextBtn) {
                this.nextBtn.onclick = function(e) {
                    e.preventDefault();
                    self.next();
                    self.resumeAutoplayAfterDelay();
                };
            }

            // Thumbnails click
            if (this.thumbnailsWrap) {
                var thumbs = this.thumbnailsWrap.querySelectorAll('.pdp-thumb-item');
                thumbs.forEach(function(t, idx) {
                    t.onclick = function() {
                        self.goTo(idx);
                        self.resumeAutoplayAfterDelay();
                    };
                });
            }

            // Hover pause on desktop
            this.container.addEventListener('mouseenter', function() {
                self.pauseAutoplay();
            });
            this.container.addEventListener('mouseleave', function() {
                self.startAutoplay();
            });

            // Touch / Mouse Drag Handling (Fluid, Native & Direction Locked)
            var onStart = function(e) {
                self.isDragging = true;
                self.startX = e.touches ? e.touches[0].clientX : e.clientX;
                self.startY = e.touches ? e.touches[0].clientY : e.clientY;
                self.currentX = self.startX;
                self.currentY = self.startY;
                self.startScrollLeft = self.track.scrollLeft;
                self.isTouchHorizontal = false;
                self.pauseAutoplay();
            };

            var onMove = function(e) {
                if (!self.isDragging) return;
                self.currentX = e.touches ? e.touches[0].clientX : e.clientX;
                self.currentY = e.touches ? e.touches[0].clientY : e.clientY;
                var diffX = self.currentX - self.startX;
                var diffY = self.currentY - self.startY;

                if (!self.isTouchHorizontal) {
                    if (Math.abs(diffX) > 8 || Math.abs(diffY) > 8) {
                        if (Math.abs(diffX) >= Math.abs(diffY)) {
                            self.isTouchHorizontal = true;
                        } else {
                            self.isDragging = false;
                            return;
                        }
                    }
                }

                if (self.isTouchHorizontal) {
                    if (e.cancelable) e.preventDefault();
                    self.track.scrollLeft = self.startScrollLeft - diffX;
                }
            };

            var onEnd = function() {
                if (!self.isDragging && !self.isTouchHorizontal) return;
                self.isDragging = false;

                if (self.isTouchHorizontal) {
                    var diffX = self.currentX - self.startX;
                    if (diffX < -self.touchThreshold) {
                        self.next();
                    } else if (diffX > self.touchThreshold) {
                        self.prev();
                    } else {
                        self.goTo(self.currentIndex);
                    }
                }
                self.resumeAutoplayAfterDelay(3500);
            };

            // Bind Touch
            this.track.addEventListener('touchstart', onStart, { passive: true });
            this.track.addEventListener('touchmove', onMove, { passive: false });
            this.track.addEventListener('touchend', onEnd, { passive: true });

            // Bind Mouse Drag
            this.track.addEventListener('mousedown', onStart);
            window.addEventListener('mousemove', onMove);
            window.addEventListener('mouseup', onEnd);

            // Sync index on native momentum scroll
            var scrollTimeout = null;
            this.track.addEventListener('scroll', function() {
                if (scrollTimeout) clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(function() {
                    if (!self.slides.length) return;
                    var slideWidth = self.slides[0].offsetWidth || 300;
                    var newIndex = Math.round(self.track.scrollLeft / slideWidth);
                    if (newIndex >= 0 && newIndex < self.slides.length && newIndex !== self.currentIndex) {
                        self.currentIndex = newIndex;
                        self.updateUI();
                    }
                }, 80);
            }, { passive: true });

            // Page Visibility change
            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    self.pauseAutoplay();
                } else {
                    self.startAutoplay();
                }
            });

            // Window Resize
            window.addEventListener('resize', function() {
                self.buildDots();
                self.updateUI();
            }, { passive: true });
        }
    }

    // ═════════════════════════════════════════════════════════════
    // INITIALIZE ALL 4 CAROUSELS INDEPENDENTLY
    // ═════════════════════════════════════════════════════════════
    document.addEventListener('DOMContentLoaded', function() {
        
        // 1. Main Product Gallery Carousel (Top)
        var mainGallery = new AgyCarousel({
            container: '#pdpGallerySlider',
            track: '#pdpMainSliderTrack',
            dotsWrap: '#pdpMainSliderDots',
            counterEl: '#pdpMainSlideCounter',
            prevBtn: '#pdpMainSlidePrev',
            nextBtn: '#pdpMainSlideNext',
            thumbnailsWrap: '#pdpMainThumbnailsStrip',
            autoplayInterval: 3800
        });

        // 2. Key Highlights Detail Image Carousel (Myntra Style)
        var keyHighlightsGallery = new AgyCarousel({
            container: '#pdpKeyHighlightsSlider',
            track: '#pdpKhTrack',
            dotsWrap: '#pdpKhDots',
            counterEl: '#pdpKhCounter',
            prevBtn: '#pdpKhPrev',
            nextBtn: '#pdpKhNext',
            autoplayInterval: 4000
        });

        // 3. Customer Reviews Carousel
        var reviewsCarousel = new AgyCarousel({
            container: '#pdpRevCarouselWrap',
            track: '#pdpReviewsTrack',
            dotsWrap: '#pdpRevDots',
            prevBtn: '#pdpRevPrev',
            nextBtn: '#pdpRevNext',
            autoplayInterval: 4800,
            isMultiItem: true
        });

        // 4. "You May Also Admire" Related Products Carousel
        var relatedCarousel = new AgyCarousel({
            container: '#pdpRelCarouselWrap',
            track: '#pdpRelTrack',
            dotsWrap: '#pdpRelDots',
            prevBtn: '#pdpRelPrev',
            nextBtn: '#pdpRelNext',
            autoplayInterval: 5000,
            isMultiItem: true
        });
    });

    // ═════════════════════════════════════════════════════════════
    // PRODUCT INTERACTION CONTROLLERS
    // ═════════════════════════════════════════════════════════════

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

        if (typeof window.closeCartDrawer === 'function') {
            window.closeCartDrawer();
        }

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
        var activeSlide = document.querySelector('#pdpMainSliderTrack .pdp-slide img');
        if (activeSlide) {
            window.open(activeSlide.src, '_blank');
        }
    };

    // WhatsApp Instant Order Flow
    window.openPdpWhatsAppOrderModal = function() {
        var activeSizeBtn = document.querySelector('.pdp-size-btn.active');
        var selSize = activeSizeBtn ? activeSizeBtn.dataset.size : (currentProduct.size[0] || 'Free Size');

        var activeColorBtn = document.querySelector('.pdp-color-btn.active');
        var selColor = activeColorBtn ? activeColorBtn.dataset.color : (currentProduct.colors[0] || 'Standard');

        var totalPrice = Number(currentProduct.price * currentQty).toLocaleString('en-IN');
        var productUrl = window.location.href;

        var text = "👑 *INSTANT ORDER — KALANIKETAN LUXURY ETHNIC*\n\n" +
                   "*Product:* " + currentProduct.name + "\n" +
                   "*SKU:* " + (currentProduct.sku || 'KN-01') + "\n" +
                   "*Price:* ₹" + totalPrice + " (Qty: " + currentQty + ")\n" +
                   "*Color:* " + selColor + " • *Size:* " + selSize + "\n\n" +
                   "*Product Link:* " + productUrl + "\n\n" +
                   "Please confirm availability and share dispatch details. Thank you!";

        var waUrl = "https://api.whatsapp.com/send?phone=919876543210&text=" + encodeURIComponent(text);
        window.open(waUrl, '_blank');
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

    // Rating selector in write review modal
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
    };

    // Helpful upvote button
    window.toggleHelpful = function(btn, currentCount) {
        if (btn.classList.contains('voted')) return;
        btn.classList.add('voted');
        btn.innerHTML = '<span>👍</span><span>(' + (currentCount + 1) + ')</span>';
        window.showToast('❤️ Thank you for your feedback!');
    };

    // Close modals on overlay backdrop click
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList && e.target.classList.contains('pdp-modal-overlay')) {
            e.target.classList.remove('open');
        }
    });

})();
</script>

</body>
</html>
