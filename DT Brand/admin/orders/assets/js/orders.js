/**
 * orders.js — Master Order Management Controller & State Engine
 * DT Brand's & Jai Hanuman Tex
 */

(function(window) {
    'use strict';

    const DT_ORDERS = {
        orders: [
            {
                id: 'DTB-001624',
                customer: 'Rajesh Kumar (Vardhman Tex)',
                customer_type: 'Wholesale B2B',
                phone: '+91 98220 19283',
                email: 'rajesh@vardhmantex.com',
                date: '2026-08-21 11:20 AM',
                updated: '2026-08-21 11:45 AM',
                items: [
                    { name: 'Kanjivaram Silk Saree Pure Zari Weave', sku: 'KNJ-001', variant: 'Royal Ruby / 5.5m', qty: 25, price: 4490, img: '/assets/images/product1.png' }
                ],
                item_count: 25,
                amount: 112250,
                payment_method: 'Bank Wire / RTGS',
                payment_status: 'paid',
                payment_ref: 'UTR-9821039812',
                shipping_method: 'Surat Central Depot Cargo Express',
                carrier: 'VRL Logistics',
                tracking_id: 'VRL-SURAT-99821',
                status: 'shipped',
                source: 'B2B Wholesale Portal',
                notes: 'Ship via VRL Ring Road Depot directly to Surat central warehouse.',
                address: {
                    billing: 'Shop 42, Textile Market, Ring Road, Surat, Gujarat - 395002',
                    shipping: 'Godown 12, Transport Nagar, Surat, Gujarat - 395010'
                }
            },
            {
                id: 'DTB-001623',
                customer: 'Pooja Sharma',
                customer_type: 'Retail Customer (B2C)',
                phone: '+91 98110 29381',
                email: 'pooja.sharma@gmail.com',
                date: '2026-08-21 10:45 AM',
                updated: '2026-08-21 11:00 AM',
                items: [
                    { name: 'Banarasi Brocade Silk Handloom', sku: 'BNR-004', variant: 'Bridal Crimson', qty: 1, price: 4990, img: '/assets/images/product2.png' }
                ],
                item_count: 1,
                amount: 4990,
                payment_method: 'UPI / PhonePe',
                payment_status: 'paid',
                payment_ref: 'UPI-20260821-4990',
                shipping_method: 'BlueDart Air Express',
                carrier: 'BlueDart',
                tracking_id: 'BD-882910291',
                status: 'delivered',
                source: 'Online Shop',
                notes: 'Gift wrap requested with handwritten note.',
                address: {
                    billing: 'Flat 402, Lotus Heights, Andheri West, Mumbai, MH - 400053',
                    shipping: 'Flat 402, Lotus Heights, Andheri West, Mumbai, MH - 400053'
                }
            },
            {
                id: 'DTB-001622',
                customer: 'Siddhi Boutique (Anjali Patel)',
                customer_type: 'Retailer / Boutique',
                phone: '+91 98765 43210',
                email: 'anjali@siddhiboutique.in',
                date: '2026-08-21 09:30 AM',
                updated: '2026-08-21 10:15 AM',
                items: [
                    { name: 'Paithani Peacock Border Handloom', sku: 'PTH-008', variant: 'Emerald Gold', qty: 10, price: 3890, img: '/assets/images/product3.png' }
                ],
                item_count: 10,
                amount: 38900,
                payment_method: 'Net Banking / HDFC',
                payment_status: 'paid',
                payment_ref: 'HDFC-88910298',
                shipping_method: 'DTDC Priority Courier',
                carrier: 'DTDC',
                tracking_id: 'DTDC-44910298',
                status: 'packed',
                source: 'B2B Wholesale Portal',
                notes: 'Packed in waterproof master carton.',
                address: {
                    billing: '22 MG Road, Ahmedabad, Gujarat - 380001',
                    shipping: '22 MG Road, Ahmedabad, Gujarat - 380001'
                }
            },
            {
                id: 'DTB-001621',
                customer: 'Meera Textiles',
                customer_type: 'WhatsApp Reseller',
                phone: '+91 98450 11223',
                email: 'meera@meeratex.com',
                date: '2026-08-20 04:15 PM',
                updated: '2026-08-20 05:00 PM',
                items: [
                    { name: 'Chanderi Zari Tissue Festive Saree', sku: 'CHD-012', variant: 'Pastel Peach', qty: 6, price: 2490, img: '/assets/images/product4.png' }
                ],
                item_count: 6,
                amount: 14940,
                payment_method: 'Razorpay / Credit Card',
                payment_status: 'paid',
                payment_ref: 'pay_RP20268819',
                shipping_method: 'Delhivery Surface',
                carrier: 'Delhivery',
                tracking_id: 'DLV-99820198',
                status: 'processing',
                source: 'WhatsApp Order',
                notes: 'Dispatched via Delhivery Surface.',
                address: {
                    billing: '45 Commercial Street, Bengaluru, Karnataka - 560001',
                    shipping: '45 Commercial Street, Bengaluru, Karnataka - 560001'
                }
            },
            {
                id: 'DTB-001620',
                customer: 'Kalyan Sarees Wholesale',
                customer_type: 'Wholesale B2B',
                phone: '+91 98330 99881',
                email: 'kalyan@kalyansarees.com',
                date: '2026-08-20 02:00 PM',
                updated: '2026-08-20 02:30 PM',
                items: [
                    { name: 'Pure Tussar Silk Hand Block Print', sku: 'TSR-019', variant: 'Beige Mustard', qty: 50, price: 2990, img: '/assets/images/product5.png' }
                ],
                item_count: 50,
                amount: 149500,
                payment_method: 'Bank Transfer / NEFT',
                payment_status: 'pending',
                payment_ref: 'NEFT-PENDING',
                shipping_method: 'Depot Transport Lot',
                carrier: 'Surat Cargo',
                tracking_id: 'SC-102938',
                status: 'pending',
                source: 'B2B Wholesale Portal',
                notes: 'Awaiting NEFT confirmation before packaging.',
                address: {
                    billing: 'Kalyan Complex, Main Bazaar, Surat, Gujarat - 395003',
                    shipping: 'Central Godown 4, Surat, Gujarat - 395003'
                }
            },
            {
                id: 'DTB-001619',
                customer: 'Ritu Varma',
                customer_type: 'Retail Customer (B2C)',
                phone: '+91 98190 77665',
                email: 'ritu.varma@hotmail.com',
                date: '2026-08-19 11:10 AM',
                updated: '2026-08-19 03:00 PM',
                items: [
                    { name: 'Kalamkari Hand Painted Silk Saree', sku: 'KLM-005', variant: 'Indigo Gold', qty: 1, price: 3290, img: '/assets/images/product6.png' }
                ],
                item_count: 1,
                amount: 3290,
                payment_method: 'Cash On Delivery',
                payment_status: 'failed',
                payment_ref: 'COD-REJECTED',
                shipping_method: 'Delhivery COD Express',
                carrier: 'Delhivery',
                tracking_id: 'DLV-COD-99182',
                status: 'cancelled',
                source: 'Online Shop',
                notes: 'Customer cancelled due to incorrect delivery address.',
                address: {
                    billing: 'House 14, Civil Lines, Jaipur, Rajasthan - 302006',
                    shipping: 'House 14, Civil Lines, Jaipur, Rajasthan - 302006'
                }
            },
            {
                id: 'DTB-001618',
                customer: 'Surat Central Depot (Stock Consignment)',
                customer_type: 'Internal Stock Transfer',
                phone: '+91 98980 11223',
                email: 'depot@jaihanumantex.in',
                date: '2026-08-19 09:00 AM',
                updated: '2026-08-19 10:00 AM',
                items: [
                    { name: 'Surat Handloom Georgette Festive Lot', sku: 'GEO-088', variant: 'Assorted (x30)', qty: 30, price: 2490, img: '/assets/images/product1.png' }
                ],
                item_count: 30,
                amount: 74700,
                payment_method: 'Internal Transfer',
                payment_status: 'paid',
                payment_ref: 'DEPOT-TRF-9982',
                shipping_method: 'Depot Shifter Van',
                carrier: 'Surat Central Depot Express',
                tracking_id: 'SC-9982',
                status: 'confirmed',
                source: 'B2B Portal',
                notes: 'Consignment confirmed for Surat Ring Road central warehouse.',
                address: {
                    billing: 'Jai Hanuman Tex HQ, Ring Road, Surat, Gujarat - 395002',
                    shipping: 'Central Depot 1, Ring Road, Surat, Gujarat - 395002'
                }
            },
            {
                id: 'DTB-001617',
                customer: 'Sneha Kulkarni',
                customer_type: 'Retail Customer (B2C)',
                phone: '+91 98112 33445',
                email: 'sneha.k@yahoo.com',
                date: '2026-08-18 06:40 PM',
                updated: '2026-08-19 08:30 AM',
                items: [
                    { name: 'Pure Mysore Silk Crepe Saree', sku: 'MYS-014', variant: 'Peacock Blue (x8)', qty: 8, price: 3290, img: '/assets/images/product2.png' }
                ],
                item_count: 8,
                amount: 26320,
                payment_method: 'UPI / GooglePay',
                payment_status: 'paid',
                payment_ref: 'UPI-889102-GPay',
                shipping_method: 'BlueDart Air Express',
                carrier: 'BlueDart Express Air',
                tracking_id: 'BD-1092',
                status: 'out_for_delivery',
                source: 'Online Shop',
                notes: 'Out for courier delivery today with OTP verification.',
                address: {
                    billing: 'B-12 Pune Cantonment, Pune, Maharashtra - 411001',
                    shipping: 'B-12 Pune Cantonment, Pune, Maharashtra - 411001'
                }
            },
            {
                id: 'DTB-001616',
                customer: 'Vandana Silk Emporium',
                customer_type: 'Wholesale B2B Reseller',
                phone: '+91 98400 88990',
                email: 'orders@vandanasale.com',
                date: '2026-08-18 11:00 AM',
                updated: '2026-08-19 02:00 PM',
                items: [
                    { name: 'Banarasi Katan Handloom Silk Lot', sku: 'BNR-099', variant: 'Royal Zari (x5)', qty: 5, price: 6490, img: '/assets/images/product3.png' }
                ],
                item_count: 5,
                amount: 32450,
                payment_method: 'Bank Wire / RTGS',
                payment_status: 'paid',
                payment_ref: 'UTR-882910398',
                shipping_method: 'VRL Cargo Depot',
                carrier: 'VRL Logistics Depot',
                tracking_id: 'VRL-7721',
                status: 'returned',
                source: 'B2B Portal',
                notes: 'Returned by consignee due to transport depot carton mismatch.',
                address: {
                    billing: 'Vandana Complex, T. Nagar, Chennai, Tamil Nadu - 600017',
                    shipping: 'Vandana Complex, T. Nagar, Chennai, Tamil Nadu - 600017'
                }
            },
            {
                id: 'DTB-001615',
                customer: 'Kavita Agarwal',
                customer_type: 'Retail Customer (B2C)',
                phone: '+91 98210 55443',
                email: 'kavita.agarwal@gmail.com',
                date: '2026-08-17 05:20 PM',
                updated: '2026-08-18 01:00 PM',
                items: [
                    { name: 'Paithani Pure Silk Traditional Saree', sku: 'PTH-001', variant: 'Magenta Gold (x1)', qty: 1, price: 4990, img: '/assets/images/product4.png' }
                ],
                item_count: 1,
                amount: 4990,
                payment_method: 'Razorpay / Card',
                payment_status: 'paid',
                payment_ref: 'pay_RP9918293',
                shipping_method: 'Delhivery Air',
                carrier: 'Delhivery Air',
                tracking_id: 'DLV-4481',
                status: 'refunded',
                source: 'Online Shop',
                notes: 'Customer returned parcel. 100% refund credited via Razorpay.',
                address: {
                    billing: 'Sector 14, Gurugram, Haryana - 122001',
                    shipping: 'Sector 14, Gurugram, Haryana - 122001'
                }
            },
            {
                id: 'DTB-001614',
                customer: 'Ananya Roy',
                customer_type: 'Retail Customer (B2C)',
                phone: '+91 98300 77112',
                email: 'ananya.roy@kolkata.in',
                date: '2026-08-17 02:15 PM',
                updated: '2026-08-17 02:30 PM',
                items: [
                    { name: 'Tussar Handloom Saree Festive Silk', sku: 'TSR-003', variant: 'Natural Beige (x1)', qty: 1, price: 2990, img: '/assets/images/product5.png' }
                ],
                item_count: 1,
                amount: 2990,
                payment_method: 'Card / Failed Gateway',
                payment_status: 'failed',
                payment_ref: 'FAIL-GATEWAY-TIMEOUT',
                shipping_method: 'Pending Payment Verification',
                carrier: 'Pending Verification',
                tracking_id: '—',
                status: 'failed',
                source: 'Online Shop',
                notes: 'Payment failed at bank gateway. Order marked failed.',
                address: {
                    billing: 'Salt Lake Sector 5, Kolkata, West Bengal - 700091',
                    shipping: 'Salt Lake Sector 5, Kolkata, West Bengal - 700091'
                }
            }
        ],

        showToast: function(message, type) {
            const existing = document.getElementById('dtToastContainer');
            if (existing) existing.remove();

            const toast = document.createElement('div');
            toast.id = 'dtToastContainer';
            toast.style.cssText = 'position:fixed; bottom:24px; right:24px; background:linear-gradient(135deg, #181512 0%, #2A241E 100%); color:#FAF5E8; border:1px solid #8A681F; border-radius:8px; padding:12px 18px; font-size:12.5px; font-weight:700; display:flex; align-items:center; gap:10px; z-index:999999; box-shadow:0 6px 20px rgba(0,0,0,0.35); animation:dtToastIn 0.25s ease-out; font-family:"Plus Jakarta Sans", sans-serif;';
            
            toast.innerHTML = `
                <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#16A34A; box-shadow:0 0 8px #16A34A;"></span>
                <span>${message}</span>
            `;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3200);
        },

        copyText: function(text, label) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text);
            } else {
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                textArea.remove();
            }
            this.showToast('📋 ' + (label || 'Text') + ' copied to clipboard!');
        }
    };

    window.DT_ORDERS = DT_ORDERS;
})(window);
