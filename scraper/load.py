import requests
import xml.etree.ElementTree as ET
import json
from dotenv import load_dotenv
import os

load_dotenv()


class DataLoader:
    def __init__(self, api_url, api_key, results_number) -> None:
        self.api_url = api_url
        self.api_key = api_key
        self.category_map = {}
        self.atribbs_map = {}
        self.results_number = results_number
        self.base_weight_price = 999
        self.find_base_weight()
        self.load_category("Włóczki", 2)

    def start(self):
        self.find_base_weight()
        for i in range(1, self.results_number+1):
            with open(f'results/products_{i}.json', 'r', encoding='utf-8') as file:
                data = json.load(file)
                self.handle_json(data)

    def handle_json(self, data):
        for product in data:
            categories_tree = product.get('categories_tree', [])
            self.load_categories(categories_tree)
            self.load_product(product)

    def find_base_weight(self):
        for i in range(1, self.results_number+1):
            with open(f'results/products_{i}.json', 'r', encoding='utf-8') as file:
                data = json.load(file)
                for product in data:
                    prices = product["prices"]
                    weights = prices["weights"]
                    if weights:
                        min_weight_price = min(prices["netto"])
                        self.base_weight_price = min(min_weight_price, self.base_weight_price)
              
    def load_category(self, cat_name, parent_id):
        if cat_name in self.category_map:
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

            self.category_map[cat_name] = cat_id
        else:
            print(f"Błąd dodawania kategorii: {response.status_code} - {response.text}")

        print("\n", end="")

    def load_categories(self, categories_tree):
        parent = self.category_map["Włóczki"]
        categories_tree = categories_tree[:-1]
        for cat_name in categories_tree:
            self.load_category(cat_name, parent)
            parent = self.category_map[cat_name]

    def load_product(self, product_dict):
        cat_id = self.category_map["Włóczki"]

        try:
            prod_name = product_dict["categories_tree"][-1]
            prod_cat = product_dict["categories_tree"][-2]
            cat_id = self.category_map[prod_cat]
        except IndexError:
            print("Brak kategorii nadrzędnych dla produktu, ustawiam default")

        prices = product_dict["prices"]

        if product_dict["prices"]["weights"]:
            attrib_name = "Waga"
            self.add_attribs(prices, "Waga")
        elif product_dict["prices"]["variants"]:
            attrib_name = "Długość"
            self.add_attribs(prices, "Długość")
            #self.add_attribs(prices, "Dowijka Zewnętrznego Koloru")
        else:
            attrib_name = None

        try:
            prod_price = prices["netto"][0]
            #prod_unit_price = prices["brutto"][0]
        except IndexError:
            prod_price = 2137
            #prod_unit_price = 2137

        product_xml = f"""<prestashop xmlns:xlink="http://www.w3.org/1999/xlink">
            <product>
                <price><![CDATA[{
                    self.base_weight_price if attrib_name else prod_price
                    }]]></price>
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
            self.load_images(product_dict["product_id"], prod_id)
            self.apply_combination(product_dict, attrib_name, prod_id)

        else:
            print(f"Błąd dodawania produktu: {response.status_code} - {response.text}")

    def load_images(self, scrapped_id, product_id):

        file = {
            "image": open(f"media/{scrapped_id}_0.jpg", "rb")
        }
        response = requests.post(
            api_url+f"images/products/{product_id}",
            files=file,
            auth=(api_key, '')
        )

        if response.status_code == 200:
            print(f"Image uploaded successfully: {scrapped_id}_0")
        else:
            print("Failed to upload image:", response.status_code, response.text)

        try:
            file = {
                "image": open(f"media/{scrapped_id}_1.jpg", "rb")
            }
        except FileNotFoundError:
            return
        response = requests.post(
            api_url+f"images/products/{product_id}",
            files=file,
            auth=(api_key, '')
        )

        if response.status_code == 200:
            print(f"Image uploaded successfully: {scrapped_id}_1")
        else:
            print("Failed to upload image:", response.status_code, response.text)

    def apply_combination(self, product_dict, attrib_name, product_id):
        prices = product_dict["prices"]
        indeks = product_dict["index"]
        if attrib_name == "Waga":
            weights = prices["weights"]
            for index, weight in enumerate(weights):
                price = round(prices["netto"][index] - self.base_weight_price, 2)
                print("priiiiice", price)
                #<ean13><![CDATA[1234567890123]]></ean13>
                #<mpn><![CDATA[123456]]></mpn>
                combination_xml = f"""<?xml version="1.0" encoding="UTF-8"?>
                <prestashop xmlns:xlink="http://www.w3.org/1999/xlink">
                    <combination>
                        <id_product><![CDATA[{product_id}]]></id_product>
                        
                        <reference><![CDATA[{indeks[8:]}]]></reference>
                        <supplier_reference><![CDATA[mfr_1]]></supplier_reference>
                        <price><![CDATA[{price}]]></price>
                        <minimal_quantity><![CDATA[1]]></minimal_quantity>
                        <associations>
                            <product_option_values nodeType="product_option_value" api="product_option_values">
                                <product_option_value>
                                    <id><![CDATA[{self.atribbs_map["Waga"][weight]["id"]}]]></id>
                                </product_option_value>
                            </product_option_values>
                        </associations>
                    </combination>
                </prestashop>
                """
                response = requests.post(
                    api_url+"combinations",
                    data=combination_xml.encode('utf-8'),
                    headers={'Content-Type': 'application/xml'},
                    auth=(api_key, '')
                )

                if response.status_code == 201:
                    response_xml = ET.fromstring(response.text)
                    atrib_id = response_xml.find('.//id').text

                    print(f"Kombinacje atrybutu {attrib_name} dodano do produktu {product_id}")
                else:
                    print("Failed wartosc atrybutu:", response.status_code, response.text)
                
        elif attrib_name == "Długość":
            variants = prices["variants"]

            for dlugosc, dowijki in variants.items():
                for dowijka, ceny in dowijki.items():
                    price = round(ceny["netto"] - self.base_weight_price, 2)
                    print("priiiiice", price)
                    #<ean13><![CDATA[1234567890123]]></ean13>
                    #<mpn><![CDATA[123456]]></mpn>
                    atrybut_dowijki = dowijka
                    if dowijka == "null":
                        atrybut_dowijki = "Wybierz"

                    combination_xml = f"""<?xml version="1.0" encoding="UTF-8"?>
                    <prestashop xmlns:xlink="http://www.w3.org/1999/xlink">
                        <combination>
                            <id_product><![CDATA[{product_id}]]></id_product>
                            
                            <reference><![CDATA[{indeks[8:]}]]></reference>
                            <supplier_reference><![CDATA[mfr_1]]></supplier_reference>
                            <price><![CDATA[{price}]]></price>
                            <minimal_quantity><![CDATA[1]]></minimal_quantity>
                            <associations>
                                <product_option_values nodeType="product_option_value" api="product_option_values">
                                    <product_option_value>
                                        <id><![CDATA[{self.atribbs_map["Długość"][dlugosc]["id"]}]]></id>
                                    </product_option_value>
                                    <product_option_value>
                                        <id><![CDATA[{self.atribbs_map["Dowijka Zewnętrznego Koloru"][atrybut_dowijki]["id"]}]]></id>
                                    </product_option_value>
                                </product_option_values>
                            </associations>
                        </combination>
                    </prestashop>
                    """
                    response = requests.post(
                        api_url+"combinations",
                        data=combination_xml.encode('utf-8'),
                        headers={'Content-Type': 'application/xml'},
                        auth=(api_key, '')
                    )

                    if response.status_code == 201:
                        response_xml = ET.fromstring(response.text)
                        atrib_id = response_xml.find('.//id').text

                        print(f"Kombinacje atrybutu {attrib_name} dodano do produktu {product_id}")
                    else:
                        print("Failed wartosc atrybutu:", response.status_code, response.text)




    def add_traits(self, prices, attrib_name):
        if attrib_name == "Waga":
            weights = prices["weights"]
            for index, weight in enumerate(weights):
                if weight in self.atribbs_map["Waga"]:
                    continue

                self.atribbs_map["Waga"][weight] = {}
             
                traits_val_xml = f"""<?xml version="1.0" encoding="UTF-8"?>
                    <prestashop xmlns:xlink="http://www.w3.org/1999/xlink">
                        <product_option_value>
                            <id_attribute_group><![CDATA[{self.atribbs_map["Waga"]["id"]}]]></id_attribute_group>
                            <name>
                                <language id="1"><![CDATA[{weight}]]></language>
                            </name>
                        </product_option_value>
                    </prestashop>
                """
                response = requests.post(
                    api_url+"product_option_values",
                    data=traits_val_xml.encode('utf-8'),
                    headers={'Content-Type': 'application/xml'},
                    auth=(api_key, '')
                )

                if response.status_code == 201:
                    response_xml = ET.fromstring(response.text)
                    atrib_id = response_xml.find('.//id').text

                    print(f"Wartosc atrybutu {attrib_name}")
                    print(f"ID atrybutu: {atrib_id}")
                    self.atribbs_map["Waga"][weight]["id"] = atrib_id
                else:
                    print("Failed wartosc atrybutu:", response.status_code, response.text)

        elif attrib_name == "Długość":
            variants = prices["variants"]
            dowijka = []
            self.add_attribs(prices, "Dowijka Zewnętrznego Koloru")
            for key, values in variants.items():
                if key in self.atribbs_map["Długość"]:
                    continue
                
                for value in values:
                    if value in dowijka:
                        continue
                    dowijka.append(value)

                self.atribbs_map["Długość"][key] = {}
                traits_val_xml = f"""<?xml version="1.0" encoding="UTF-8"?>
                    <prestashop xmlns:xlink="http://www.w3.org/1999/xlink">
                        <product_option_value>
                            <id_attribute_group><![CDATA[{self.atribbs_map["Długość"]["id"]}]]></id_attribute_group>
                            <name>
                                <language id="1"><![CDATA[{key}]]></language>
                            </name>
                        </product_option_value>
                    </prestashop>
                """
                response = requests.post(
                    api_url+"product_option_values",
                    data=traits_val_xml.encode('utf-8'),
                    headers={'Content-Type': 'application/xml'},
                    auth=(api_key, '')
                )

                if response.status_code == 201:
                    response_xml = ET.fromstring(response.text)
                    atrib_id = response_xml.find('.//id').text

                    print(f"Wartosc atrybutu {attrib_name}")
                    print(f"ID atrybutu: {atrib_id}")
                    self.atribbs_map["Długość"][key]["id"] = atrib_id
                else:
                    print("Failed wartosc atrybutu:", response.status_code, response.text)

            for dowija in dowijka:
                key = dowija
                if dowija == "null":
                    key = "Wybierz"

                if key in self.atribbs_map["Dowijka Zewnętrznego Koloru"]:
                    continue

                self.atribbs_map["Dowijka Zewnętrznego Koloru"][key] = {}
                traits_val_xml = f"""<?xml version="1.0" encoding="UTF-8"?>
                    <prestashop xmlns:xlink="http://www.w3.org/1999/xlink">
                        <product_option_value>
                            <id_attribute_group><![CDATA[{self.atribbs_map["Dowijka Zewnętrznego Koloru"]["id"]}]]></id_attribute_group>
                            <name>
                                <language id="1"><![CDATA[{key}]]></language>
                            </name>
                        </product_option_value>
                    </prestashop>
                """
                response = requests.post(
                    api_url+"product_option_values",
                    data=traits_val_xml.encode('utf-8'),
                    headers={'Content-Type': 'application/xml'},
                    auth=(api_key, '')
                )

                if response.status_code == 201:
                    response_xml = ET.fromstring(response.text)
                    atrib_id = response_xml.find('.//id').text

                    print(f"Wartosc atrybutu Dowijka Zewnętrznego Koloru")
                    print(f"ID atrybutu: {atrib_id}")
                    self.atribbs_map["Dowijka Zewnętrznego Koloru"][key]["id"] = atrib_id
                else:
                    print("Failed wartosc atrybutu:", response.status_code, response.text)

        elif attrib_name == "Dowijka Zewnętrznego Koloru":
            return

        print(self.atribbs_map)

    def add_attribs(self, prices, attrib_name):

        # xml = f"""<prestashop xmlns:xlink="http://www.w3.org/1999/xlink">
        #         <product_feature>
        #             <name>
        #                 <language id="1"><![CDATA[Waga]]></language>
        #             </name>
        #         </product_feature>
        #     </prestashop>
        # """ funkcje

        if attrib_name in self.atribbs_map:
            self.add_traits(prices, attrib_name)
            return

        xml = f"""<?xml version="1.0" encoding="UTF-8"?>
            <prestashop xmlns:xlink="http://www.w3.org/1999/xlink">
                <product_option>
                    <is_color_group><![CDATA[0]]></is_color_group>
                    <group_type><![CDATA[select]]></group_type>
                    <name>
                        <language id="1"><![CDATA[{attrib_name}]]></language>
                    </name>
                    <public_name>
                        <language id="1"><![CDATA[{attrib_name}]]></language>
                    </public_name>
                </product_option>
            </prestashop>
        """

        response = requests.post(
            api_url+"product_options",
            data=xml.encode('utf-8'),
            headers={'Content-Type': 'application/xml'},
            auth=(api_key, '')
        )

        if response.status_code == 201:
            response_xml = ET.fromstring(response.text)
            atrib_id = response_xml.find('.//id').text

            print("Atrybut dodany.")
            print(f"ID atrybutu: {atrib_id}")
            self.atribbs_map[attrib_name] = {}
            self.atribbs_map[attrib_name]["id"] = atrib_id
            self.add_traits(prices, attrib_name)
        else:
            print("Failed to upload image:", response.status_code, response.text)


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


if __name__ == "__main__":
    api_url = "http://localhost:8000/api/"
    api_key = os.getenv("api_key")
    RESULTS_PAGES = 21  #1 #21
    dloader = DataLoader(api_url, api_key, RESULTS_PAGES)
    dloader.start()
    print(dloader.atribbs_map)
    #add_combination(1, 1)
    
