import requests
import xml.etree.ElementTree as ET
import json
import sys

# Konfiguracja API
api_url = "http://localhost:8000/api/"
api_key = "MPGNW819C93QD9S6L5HBKWJ59ELPC1D2"


def init():
    manufacturer = """<?xml version="1.0" encoding="UTF-8"?>
        <prestashop xmlns:xlink="http://www.w3.org/1999/xlink">
            <manufacturer>
                <name>ACMEManufacturer</name>
            </manufacturer>
        </prestashop>
    """

    supplier = """<?xml version="1.0" encoding="UTF-8"?>
        <prestashop xmlns:xlink="http://www.w3.org/1999/xlink">
            <supplier>
                <name>ACMESupplier</name>
            </supplier>
        </prestashop>
    """

    response = requests.post(
        api_url+"manufacturers",
        data=manufacturer.encode('utf-8'),
        headers={'Content-Type': 'application/xml'},
        auth=(api_key, '')
    )

    print(response.text)

    response = requests.post(
        api_url+"suppliers",
        data=supplier.encode('utf-8'),
        headers={'Content-Type': 'application/xml'},
        auth=(api_key, '')
    )

    print(response.text)


def load_product(product_dict, category_map):
    cat_id = category_map["Włóczki"]

    try:
        prod_name = product_dict["categories_tree"][-1]
        prod_cat = product_dict["categories_tree"][-2]
        cat_id = category_map[prod_cat]
    except IndexError:
        print("Brak kategorii nadrzędnych dla produktu, ustawiam default")

    prices = product_dict["prices"]
    try:
        prod_price = prices["netto"][0]
        prod_unit_price = prices["brutto"][0]
    except IndexError:
        prod_price = 2137
        prod_unit_price = 2137

    product_xml = f"""<prestashop xmlns:xlink="http://www.w3.org/1999/xlink">
        <product>
            <price><![CDATA[{prod_price}]]></price>
            <id_category_default><![CDATA[2]]></id_category_default>
            <id_tax_rules_group><![CDATA[1]]></id_tax_rules_group>
            <type><![CDATA[simple]]></type>
            <id_shop_default><![CDATA[1]]></id_shop_default>
            <active><![CDATA[1]]></active>
            <available_for_order><![CDATA[1]]></available_for_order>
            <show_price><![CDATA[1]]></show_price>
            <visibility><![CDATA[both]]></visibility>
            <state><![CDATA[1]]></state>
            <description>
                <language id="1"><![CDATA[{prod_name} opis]]></language>
            </description>
            <name>
                <language id="1"><![CDATA[{prod_name}]]></language>
            </name>
            <link_rewrite>
                <language id="1"><![CDATA[{prod_name}]]></language>
            </link_rewrite>
            <associations>
                <categories>
                    <category>
                        <id><![CDATA[{cat_id }]]></id>
                    </category>
                </categories>
            </associations>
        </product>
    </prestashop>
    """

    response = requests.post(
        api_url+"products",
        data=product_xml.encode('utf-8'),
        headers={'Content-Type': 'application/xml'},
        auth=(api_key, '')
    )

    if response.status_code == 201:

        response_xml = ET.fromstring(response.text)
        prod_id = response_xml.find('.//id').text

        print("Produkt został pomyślnie dodany.")
        print(f"ID kategorii: {cat_id}")
        print(f"ID produktu: {prod_id}")

    else:
        print(f"Błąd dodawania produktu: {response.status_code} - {response.text}")


def load_categories(categories_tree, cat_map):
    parent = cat_map["Włóczki"]
    categories_tree = categories_tree[:-1]
    for cat_name in categories_tree:
        load_category(cat_name, parent, cat_map)
        parent = cat_map[cat_name]


def load_category(cat_name, parent_id, cat_map):
    if cat_name in cat_map:
        print("Kategoria już jest obecna")
        print("\n", end="")
        return

    request_xml = f"""<?xml version="1.0" encoding="UTF-8"?>
        <prestashop xmlns:xlink="http://www.w3.org/1999/xlink">
            <category>
                <name>
                    <language id="1"><![CDATA[{cat_name}]]></language>
                </name>
                <link_rewrite>
                    <language id="1"><![CDATA[{cat_name}]]></language>
                </link_rewrite>
                <description>
                    <language id="1"><![CDATA[{cat_name} opis]]></language>
                </description>
                <active>1</active>
                <id_parent>{parent_id}</id_parent>
            </category>
        </prestashop>"""

    response = requests.post(
        api_url+"categories",
        data=request_xml.encode('utf-8'),
        headers={'Content-Type': 'application/xml'},
        auth=(api_key, '')
    )

    if response.status_code == 201:

        response_xml = ET.fromstring(response.text)
        cat_id = response_xml.find('.//id').text

        print("Kategoria została pomyślnie dodana.")
        print(f"ID kategorii: {cat_id}")
        print(f"Nazwa kategorii: {cat_name}")

        cat_map[cat_name] = cat_id
    else:
        print(f"Błąd dodawania kategorii: {response.status_code} - {response.text}")

    print("\n", end="")


def handle_json(data, category_map):
    for product in data:
        categories_tree = product.get('categories_tree', [])
        load_categories(categories_tree, category_map)
        load_product(product, category_map)


if __name__ == "__main__":
    category_map = {}
    load_category("Włóczki", 2, category_map)
    RESULTS_PAGES = 21

    for i in range(1, RESULTS_PAGES+1):
        with open(f'results/products_{i}.json', 'r', encoding='utf-8') as file:
            data = json.load(file)
            handle_json(data, category_map)

        
    
    
