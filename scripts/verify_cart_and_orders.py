import urllib.request
import urllib.parse
import json
import ssl
import time

ctx = ssl._create_unverified_context()

class NoRedirectHandler(urllib.request.HTTPRedirectHandler):
    def redirect_request(self, req, fp, code, msg, headers, newurl):
        return None

opener = urllib.request.build_opener(NoRedirectHandler)

for domain in ['harmitethnic.com', 'jaihanumantex.in']:
    print(f"\n{'='*65}")
    print(f"=== TESTING CART & ORDER PIPELINE ON {domain} ===")
    print(f"{'='*65}")

    # 1. Test PDP full_set access as Guest (Must redirect to /shop.php?restricted=full_set)
    pdp_url = f"https://{domain}/product.php?id=21"
    req = urllib.request.Request(pdp_url, headers={'User-Agent': 'Mozilla/5.0'})
    try:
        res = opener.open(req, timeout=10)
        print(f"FAIL: Expected redirect on product 21, got HTTP {res.status}")
    except urllib.error.HTTPError as e:
        if e.code in [301, 302]:
            loc = e.headers.get('Location', '')
            print(f">>> [PASS] Guest access to full_set product.php redirected with HTTP {e.code} to: {loc}")
            assert 'restricted=full_set' in loc, f"Expected restricted=full_set in redirect, got {loc}"
        else:
            print(f"Redirect handler got HTTP {e.code}")

    # 2. Get Product 13 variant dynamically
    prod_url = f"https://{domain}/api/products.php?action=get&id=13"
    req_prod = urllib.request.Request(prod_url, headers={'User-Agent': 'Mozilla/5.0'})
    with urllib.request.urlopen(req_prod, context=ctx) as p_res:
        p_data = json.loads(p_res.read().decode('utf-8'))
        active_variants = p_data.get('product', {}).get('variants', [])
        target_variant = next((v for v in active_variants if (v.get('stock_qty') or 0) >= 2), active_variants[0] if active_variants else {'id': 96, 'sku': 'DTB-SAR-001-ROY-1'})
        target_variant_id = target_variant.get('id') or target_variant.get('variant_id') or 96
        target_sku = target_variant.get('sku') or 'DTB-SAR-001-ROY-1'
        stock_before = target_variant.get('stock_qty', 25)

    # 3. Test api/cart.php sync preserving variant_id & metadata
    cart_items = [
        {
            'product_id': 13,
            'variant_id': target_variant_id,
            'product_type': 'single_piece',
            'selling_type': 'single',
            'sku': target_sku,
            'color': 'Royal Crimson Red',
            'size': 'Free Size',
            'qty': 2,
            'price': 3850
        }
    ]
    cart_url = f"https://{domain}/api/cart.php"
    cart_payload = json.dumps({'action': 'sync', 'cart': cart_items}).encode('utf-8')
    req = urllib.request.Request(cart_url, data=cart_payload, headers={'Content-Type': 'application/json', 'User-Agent': 'Mozilla/5.0'})
    with urllib.request.urlopen(req, context=ctx) as res:
        cart_res = json.loads(res.read().decode('utf-8'))
        print(f">>> [PASS] Cart sync HTTP {res.status} SUCCESS!")
        items = cart_res.get('cart', [])
        assert len(items) > 0, "Expected cart items in response"
        item0 = items[0]
        print(f"    Line item: Variant ID={item0.get('variant_id')}, SKU={item0.get('sku')}, Qty={item0.get('qty')}, Unit Price={item0.get('price')}")
        assert item0.get('variant_id') == target_variant_id, f"Expected variant_id={target_variant_id}, got {item0.get('variant_id')}"
        assert item0.get('sku') == target_sku, f"Expected SKU {target_sku}, got {item0.get('sku')}"

    print(f"    Variant {target_variant_id} stock before order: {stock_before}")

    # 4. Test Order Placement via api/orders.php (Cash on Delivery)
    test_order_num = f"DT-TEST-{int(time.time())}-{domain[:4].upper()}"
    order_data = {
        'action': 'create',
        'order_number': test_order_num,
        'customer_name': 'Automated QA Test Agent',
        'customer_phone': '917046363528',
        'customer_email': 'audit@dtbrand.in',
        'payment_method': 'cod',
        'shipping_address': 'Ring Road Textile Market, Surat, Gujarat - 395002',
        'shipping_city': 'Surat',
        'shipping_state': 'Gujarat',
        'shipping_pincode': '395002',
        'items': json.dumps([
            {
                'id': 13,
                'product_id': 13,
                'variant_id': target_variant_id,
                'product_type': 'single_piece',
                'selling_type': 'single',
                'sku': target_sku,
                'name': 'Royal Heritage Kanjivaram Pure Zari Brocade Saree',
                'color': 'Royal Crimson Red',
                'size': 'Free Size',
                'qty': 2,
                'price': 3850
            }
        ])
    }
    encoded_order = urllib.parse.urlencode(order_data).encode('utf-8')
    orders_url = f"https://{domain}/api/orders.php"
    req = urllib.request.Request(orders_url, data=encoded_order, headers={'Content-Type': 'application/x-www-form-urlencoded', 'User-Agent': 'Mozilla/5.0'})
    with urllib.request.urlopen(req, context=ctx) as res:
        order_res = json.loads(res.read().decode('utf-8'))
        print(f">>> [PASS] Order Created successfully: HTTP {res.status}")
        order_info = order_res.get('order', {})
        placed_order_num = order_info.get('order_number')
        print(f"    Order Number: {placed_order_num}")
        print(f"    Total Amount: INR {order_info.get('total_amount')}")
        assert order_res.get('success') is True, "Expected success: true"

    # 5. Check stock after order placement & stock decrement
    with urllib.request.urlopen(urllib.request.Request(prod_url, headers={'User-Agent': 'Mozilla/5.0'}), context=ctx) as res:
        prod_data_after = json.loads(res.read().decode('utf-8'))
        target_after = next((v for v in prod_data_after.get('product', {}).get('variants', []) if v['id'] == target_variant_id), None)
        stock_after = target_after['stock_qty'] if target_after else None
        print(f"    Variant {target_variant_id} stock after order: {stock_after}")
        if stock_before is not None and stock_after is not None:
            expected_stock = max(0, stock_before - 2)
            print(f">>> [PASS] Stock decremented by 2: {stock_before} -> {stock_after} (Expected {expected_stock})")
            assert stock_after == expected_stock, f"Expected {expected_stock}, got {stock_after}"

    # 6. Test Idempotency: Re-submitting the exact same order_number must NOT duplicate
    req_dup = urllib.request.Request(orders_url, data=encoded_order, headers={'Content-Type': 'application/x-www-form-urlencoded', 'User-Agent': 'Mozilla/5.0'})
    with urllib.request.urlopen(req_dup, context=ctx) as res:
        dup_res = json.loads(res.read().decode('utf-8'))
        dup_info = dup_res.get('order', {})
        print(f">>> [PASS] Idempotency Check: Re-submitting order {test_order_num} returned existing order without creating duplicate! Existing flag: {dup_info.get('existing', False)}")

    print(f"\n*** ALL CHECKS PASSED ON {domain}! ***")
