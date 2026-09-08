import urllib.request
import json
import ssl

ctx = ssl._create_unverified_context()

def probe(base_url):
    print(f"=== Probing {base_url} ===")
    url = f"{base_url}/api/products.php"
    req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})
    try:
        with urllib.request.urlopen(req, context=ctx, timeout=15) as res:
            data = json.loads(res.read().decode('utf-8'))
            products = data.get('products', [])
            print(f"Total Products: {len(products)}")
            for p in products:
                pid = p.get('id')
                name = p.get('name')
                ptype = p.get('product_type')
                stype = p.get('selling_type')
                variants = p.get('variants', [])
                print(f" - Product #{pid}: '{name}' | Type: {ptype} | Selling: {stype} | Variants: {len(variants)}")
                if variants:
                    v0 = variants[0]
                    print(f"    Sample Variant: ID={v0.get('id') or v0.get('variant_id')} Color={v0.get('color')} Size={v0.get('size')} Price={v0.get('price')} Wholesale={v0.get('wholesale_price')}")
    except Exception as e:
        print(f"Error probing {base_url}: {e}")

probe("https://harmitethnic.com")
probe("https://jaihanumantex.in")
