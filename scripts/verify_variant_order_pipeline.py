import urllib.request
import urllib.parse
import json
import ssl
import time

ctx = ssl._create_unverified_context()

for domain in ['harmitethnic.com', 'jaihanumantex.in']:
    print(f"\n{'='*70}")
    print(f"=== TESTING VARIANT ID PERSISTENCE & ORDER PIPELINE ON {domain} ===")
    print(f"{'='*70}")

    # 1. Place order with explicit variant_id
    test_order_num = f"DT-VAR-{int(time.time())}-{domain[:4].upper()}"
    test_phone = f"98{int(time.time() * 1000 % 100000000):08d}"
    order_data = {
        'action': 'create',
        'order_number': test_order_num,
        'customer_name': 'Precision Variant QA Consignee',
        'customer_phone': test_phone,
        'customer_email': 'variant-qa@dtbrand.in',
        'payment_method': 'cod',
        'shipping_address': 'Shop 42, Millenium Textile Market, Ring Road, Surat, Gujarat - 395002',
        'shipping_city': 'Surat',
        'shipping_state': 'Gujarat',
        'shipping_pincode': '395002',
        'items': json.dumps([
            {
                'id': 13,
                'product_id': 13,
                'variant_id': 57,
                'product_type': 'single_piece',
                'selling_type': 'single_piece',
                'sku': 'DTB-SAR-001-ROY-1',
                'name': 'Royal Heritage Kanjivaram Pure Zari Brocade Saree',
                'color': 'Royal Crimson Red',
                'size': 'Free Size',
                'qty': 1,
                'price': 3850
            }
        ])
    }

    orders_url = f"https://{domain}/api/orders.php"
    encoded_order = urllib.parse.urlencode(order_data).encode('utf-8')
    req = urllib.request.Request(orders_url, data=encoded_order, headers={'Content-Type': 'application/x-www-form-urlencoded', 'User-Agent': 'Mozilla/5.0'})
    with urllib.request.urlopen(req, context=ctx) as res:
        order_res = json.loads(res.read().decode('utf-8'))
        print(f">>> [PASS] Order Created successfully: HTTP {res.status}")
        order_info = order_res.get('order', {})
        order_id = order_info.get('id')
        print(f"    Order Number: {order_info.get('order_number')}")
        print(f"    Order DB ID: {order_id}")
        print(f"    Total Amount: INR {order_info.get('total_amount')}")
        assert order_res.get('success') is True, "Expected success: true"
        assert order_id and int(order_id) > 0, "Expected positive order ID"

    # 2. Test Reseller Margin Calculator restriction on full_set product
    calc_url = f"https://{domain}/api/reseller.php?action=calculate_margin&product_id=21&margin_percent=15"
    req_calc = urllib.request.Request(calc_url, headers={'User-Agent': 'Mozilla/5.0'})
    try:
        urllib.request.urlopen(req_calc, context=ctx)
        print("FAIL: Expected HTTP 403 on reseller calculate_margin for product 21 (full_set)")
        assert False, "Reseller calculate_margin should have failed with 403"
    except urllib.error.HTTPError as e:
        print(f">>> [PASS] Reseller margin calculation on full_set product 21 blocked with HTTP {e.code} (Forbidden)")
        assert e.code == 403, f"Expected 403, got {e.code}"

    # 3. Test Wholesale Lot calculation on full_set product 21
    ws_calc_url = f"https://{domain}/api/wholesale.php?action=calculate_lot&product_id=21&lot_type=full_set"
    req_ws = urllib.request.Request(ws_calc_url, headers={'User-Agent': 'Mozilla/5.0'})
    with urllib.request.urlopen(req_ws, context=ctx) as res:
        ws_res = json.loads(res.read().decode('utf-8'))
        print(f">>> [PASS] Wholesale lot calculation for full_set product 21: HTTP {res.status}, pieces={ws_res.get('pieces')}, success={ws_res.get('success')}")
        assert ws_res.get('success') is True, "Expected success: true for wholesale lot calc"
        assert ws_res.get('pieces') == 6, f"Expected 6 pieces, got {ws_res.get('pieces')}"

    print(f"\n*** ALL TESTS PASSED WITH 100% SUCCESS ON {domain}! ***")
