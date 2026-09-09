import urllib.request
import urllib.parse
import http.cookiejar
import json
import ssl
import time

ctx = ssl._create_unverified_context()

for domain in ['harmitethnic.com', 'jaihanumantex.in']:
    print(f"\n{'='*60}")
    print(f"=== TESTING ROLE GATES ON {domain} ===")
    print(f"{'='*60}")

    # 1. Guest list query
    req = urllib.request.Request(f'https://{domain}/api/products.php', headers={'User-Agent': 'Mozilla/5.0'})
    with urllib.request.urlopen(req, context=ctx) as res:
        data = json.loads(res.read().decode('utf-8'))
        p_ids = [p['id'] for p in data.get('products', [])]
        print(f"Guest product count: {len(p_ids)}, IDs: {p_ids}")
        assert 21 not in p_ids, 'FAIL: Product #21 (full_set) leaked to guest list!'
        print(">>> [PASS] Guest list filtering: full_set excluded correctly.")

    # 2. Guest single product query for full_set (Product #21)
    req = urllib.request.Request(f'https://{domain}/api/products.php?id=21', headers={'User-Agent': 'Mozilla/5.0'})
    try:
        urllib.request.urlopen(req, context=ctx)
        print("FAIL: Product #21 allowed for guest!")
    except urllib.error.HTTPError as e:
        print(f">>> [PASS] Guest direct lookup of full_set: Blocked with HTTP {e.code} (Expected 403)")
        assert e.code == 403, f"Expected 403, got {e.code}"

    # 3. Authenticated Wholesaler Session via api/auth.php
    cj_ws = http.cookiejar.CookieJar()
    opener_ws = urllib.request.build_opener(urllib.request.HTTPCookieProcessor(cj_ws), urllib.request.HTTPSHandler(context=ctx))
    ws_phone = f"99{int(time.time() * 1000 % 100000000):08d}"
    reg_ws_data = urllib.parse.urlencode({
        'action': 'register',
        'name': 'Verified Wholesaler Partner',
        'phone': ws_phone,
        'password': 'Password@123',
        'type': 'wholesale',
        'city': 'Surat',
        'state': 'Gujarat'
    }).encode('utf-8')
    reg_req = urllib.request.Request(f'https://{domain}/api/auth.php', data=reg_ws_data, headers={'Content-Type': 'application/x-www-form-urlencoded', 'User-Agent': 'Mozilla/5.0'})
    with opener_ws.open(reg_req) as reg_res:
        reg_json = json.loads(reg_res.read().decode('utf-8'))
        print(f">>> [PASS] Wholesaler registered/logged in: HTTP {reg_res.status}, user_id={reg_json.get('user', {}).get('id')}")

    # Wholesaler query for full_set (Product #21)
    req_ws = urllib.request.Request(f'https://{domain}/api/products.php?id=21', headers={'User-Agent': 'Mozilla/5.0'})
    with opener_ws.open(req_ws) as res:
        resData = json.loads(res.read().decode('utf-8'))
        p21 = resData.get('product', resData)
        print(f">>> [PASS] Wholesaler lookup of full_set: HTTP {res.status} SUCCESS!")
        print(f"    Product Title: {p21.get('name')}")
        print(f"    Selling Type: {p21.get('selling_type')}")
        print(f"    Variants Count: {len(p21.get('variants', []))}")
        assert p21.get('selling_type') == 'full_set', "Expected selling_type == 'full_set'"

    # 4. Authenticated Retailer Session via api/auth.php
    cj_ret = http.cookiejar.CookieJar()
    opener_ret = urllib.request.build_opener(urllib.request.HTTPCookieProcessor(cj_ret), urllib.request.HTTPSHandler(context=ctx))
    ret_phone = f"98{int(time.time() * 1000 % 100000000):08d}"
    reg_ret_data = urllib.parse.urlencode({
        'action': 'register',
        'name': 'Verified Retailer Partner',
        'phone': ret_phone,
        'password': 'Password@123',
        'type': 'retailer',
        'city': 'Surat',
        'state': 'Gujarat'
    }).encode('utf-8')
    reg_req_ret = urllib.request.Request(f'https://{domain}/api/auth.php', data=reg_ret_data, headers={'Content-Type': 'application/x-www-form-urlencoded', 'User-Agent': 'Mozilla/5.0'})
    with opener_ret.open(reg_req_ret) as reg_res:
        reg_json = json.loads(reg_res.read().decode('utf-8'))
        print(f">>> [PASS] Retailer registered/logged in: HTTP {reg_res.status}, user_id={reg_json.get('user', {}).get('id')}")

    # Retailer query for full_set (Product #21)
    req_ret = urllib.request.Request(f'https://{domain}/api/products.php?id=21', headers={'User-Agent': 'Mozilla/5.0'})
    with opener_ret.open(req_ret) as res:
        resData = json.loads(res.read().decode('utf-8'))
        p21_ret = resData.get('product', resData)
        print(f">>> [PASS] Retailer lookup of full_set: HTTP {res.status} SUCCESS!")
        assert p21_ret.get('selling_type') == 'full_set', "Expected selling_type == 'full_set'"

    # 5. Guest single piece lookup (Product #13)
    req = urllib.request.Request(f'https://{domain}/api/products.php?id=13', headers={'User-Agent': 'Mozilla/5.0'})
    with urllib.request.urlopen(req, context=ctx) as res:
        resData = json.loads(res.read().decode('utf-8'))
        p13 = resData.get('product', resData)
        print(f">>> [PASS] Guest lookup of single piece (#13): HTTP {res.status} SUCCESS!")
        print(f"    Product Title: {p13.get('name')}")
        print(f"    Selling Type: {p13.get('selling_type')}")
        variants = p13.get('variants', [])
        print(f"    Variants Count: {len(variants)}")
        assert len(variants) > 0, "Expected variants for product 13"
        v0 = variants[0]
        print(f"    Variant 0: ID={v0.get('id')}, variant_id={v0.get('variant_id')}, color={v0.get('color')}, size={v0.get('size')}, price={v0.get('price')}")
        assert v0.get('variant_id') is not None or v0.get('id') is not None, "Expected variant id to be populated"
