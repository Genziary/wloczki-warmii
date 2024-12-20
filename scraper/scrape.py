import requests
import os
from bs4 import BeautifulSoup
from utils import extract_numerical_value, extract_numerical_integer_value, benchmark
import json

DATA_FOLDER = os.path.join(os.path.dirname(os.getcwd()), 'results')
RESULTS_FOLDER = os.path.join(DATA_FOLDER, 'products')
MEDIA_FOLDER = os.path.join(DATA_FOLDER, 'media')


def get_brutto_netto_prices(product_soup):
    """
    Function to extract prices from product div
    """
    brutto_price = product_soup.find("span", itemprop="price").get_text(strip=True)
    netto_price = product_soup.find("div", class_="tax-shipping-delivery-label").get_text(strip=True)
    extracted_brutto_price = extract_numerical_value(brutto_price)
    extracted_netto_price = extract_numerical_value(netto_price)

    return extracted_brutto_price, extracted_netto_price


@benchmark
def get_dynamic_variants_prices(headers, product_id, length, outcolor):
    """
    Function to scrape product prices at different variants
    """
    ajax_url = (
                    f"https://wloczkiwarmii.pl/pl/index.php?controller=product"
                    f"&id_product={product_id}&id_customization=0"
                    f"&group%5B5%5D={length}"
                    f"&group%5B6%5D={outcolor}&qty=1"
                )
    form_data = {
        'quickview': 0,
        'ajax': 1,
        'action': 'refresh',
        'quantity_wanted': 1
    }
    response = requests.post(ajax_url, headers=headers, data=form_data)
    if response.status_code == 200:
        try:
            product_prices = BeautifulSoup(response.json()["product_prices"], "html.parser")
            brutto, netto = get_brutto_netto_prices(product_prices)
            return brutto, netto
        except ValueError:
            return {"error": "Invalid JSON response"}
    else:
        return {"error": f"Failed to fetch price. Status code: {response.status_code}"}


@benchmark
def get_dynamic_weight_prices(headers, product_id, group_value):
    """
    Function to scrape product prices at different weights
    """
    ajax_url = (
                    f"https://wloczkiwarmii.pl/pl/index.php?controller=product"
                    f"&id_product={product_id}&id_customization=0"
                    f"&group%5B7%5D={group_value}&qty=1"
                )
    form_data = {
        'quickview': 0,
        'ajax': 1,
        'action': 'refresh',
        'quantity_wanted': 1
    }

    response = requests.post(ajax_url, headers=headers, data=form_data)
    if response.status_code == 200:
        try:
            product_prices = BeautifulSoup(response.json()["product_prices"], "html.parser")
            brutto, netto = get_brutto_netto_prices(product_prices)
            return brutto, netto
        except ValueError:
            return {"error": "Invalid JSON response"}
    else:
        return {"error": f"Failed to fetch price. Status code: {response.status_code}"}


@benchmark
def scrape_product_features(features_soup):
    """
    Function to scrape product's features and its values from an individual product page.
    """
    features_list = features_soup.find("dl", class_="data-sheet")
    names = features_list.find_all("dt", class_="name")
    values = features_list.find_all("dd", class_="value")

    return_dict = {}
    for name, value in zip(names, values):
        return_dict[name.get_text(strip=True)] = value.get_text(strip=True)

    return return_dict


@benchmark
def scrape_product_details(product_url, headers):
    """
    Function to scrape product details from an individual product page.
    """
    product_response = requests.get(product_url, headers=headers)
    if product_response.status_code == 200:
        product_soup = BeautifulSoup(product_response.content, "html.parser")

        # Extract product details
        container = product_soup.find("div", class_="breadcrumb_container")
        categories = container.find_all("span", itemprop="name")
        categories_tree = [category.get_text(strip=True) for category in categories][2:]

        product_info_div = product_soup.find("div", class_="col-md-7")
        div_with_id = product_soup.find("div", class_="product-desc")
        product_id = extract_numerical_integer_value(str(div_with_id))
        print(f"Currently scraping - {product_id}")
        index = product_info_div.find("p").get_text(strip=True)

        description = product_soup.find("div", class_="product-description")
        features_soup = product_soup.find("section", class_="product-features")

        weight_select = product_soup.find("select", {"id": "group_7"})
        length_select = product_soup.find("select", {"id": "group_5"})
        outcolor_select = product_soup.find("select", {"id": "group_6"})

        product_prices = {}
        brutto_prices = []
        netto_prices = []
        weights = []
        variants = {}
        features = scrape_product_features(features_soup)

        if weight_select:
            weight_options = weight_select.find_all("option")
            for option in weight_options:
                weight_value = option["value"]
                brutto, netto = get_dynamic_weight_prices(headers, product_id, weight_value)
                weights.append(option.get_text(strip=True))
                brutto_prices.append(brutto)
                netto_prices.append(netto)
        elif length_select and outcolor_select:

            length_options = length_select.find_all("option")
            outcolor_options = outcolor_select.find_all("option")

            for l_option in length_options:
                l_value = l_option["value"]
                l_title_val = extract_numerical_integer_value(l_option["title"])

                if l_title_val not in variants:
                    variants[l_title_val] = {}

                for oc_option in outcolor_options:
                    oc_value = oc_option["value"]
                    oc_title_val = extract_numerical_integer_value(oc_option["title"])

                    brutto, netto = get_dynamic_variants_prices(headers, product_id, l_value, oc_value)
                    price = {"brutto": brutto, "netto": netto}

                    variants[l_title_val][oc_title_val] = price
        else:
            brutto, netto = get_brutto_netto_prices(product_soup)
            brutto_prices.append(brutto)
            netto_prices.append(netto)

        product_prices["brutto"] = brutto_prices
        product_prices["netto"] = netto_prices
        product_prices["weights"] = weights
        product_prices["variants"] = variants

        save_image(product_soup, product_id, 0)
        save_image(product_soup, product_id, 1)

        return {
            "categories_tree": categories_tree,
            "index": index,
            "prices": product_prices,
            "product_id": product_id,
            "description": str(description),
            "features": features
        }
    else:
        print(f"Failed to retrieve product page: {product_url}. Status code: {product_response.status_code}")
        return None


def scrape_product_urls(page_url, headers):
    """
    Scrape product URLs from a single page.
    """
    product_urls = []
    response = requests.get(page_url, headers=headers)

    if response.status_code == 200:
        soup = BeautifulSoup(response.content, "html.parser")
        products = soup.find_all("div", class_="img_block")

        for product in products:
            anchor = product.find("a", class_="thumbnail product-thumbnail")
            if anchor and "href" in anchor.attrs:
                product_urls.append(anchor["href"])
    else:
        print(f"Failed to retrieve page {page_url}. Status code: {response.status_code}")

    return product_urls


@benchmark
def save_to_json(products, page_number):
    save_path = os.path.join(RESULTS_FOLDER, f'products_{page_number}.json')
    os.makedirs(os.path.dirname(save_path), exist_ok=True)
    with open(save_path, 'w', encoding='utf-8') as json_file:
        json.dump(products, json_file, ensure_ascii=False, indent=4)


def save_image(soup, product_id, photo_number):
    save_path = os.path.join(MEDIA_FOLDER, f'{product_id}_{photo_number}.jpg')
    if photo_number == 0:
        img_tag = soup.find('div', class_="product-cover").find("img")

        if img_tag and 'src' in img_tag.attrs:
            img_url = img_tag['src']
            img_response = requests.get(img_url)
            os.makedirs(os.path.dirname(save_path), exist_ok=True)

            if img_response.status_code == 200:
                with open(save_path, 'wb') as file:
                    file.write(img_response.content)
                print(f"Image successfully downloaded: {save_path}")
            else:
                print("Failed to download the image.")
        else:
            print("No image found on the page.")
    else:
        img_tag = soup.find("img", class_="thumb js-thumb")
        if img_tag and 'data-image-large-src' in img_tag.attrs:
            img_url = img_tag['data-image-large-src']
            img_response = requests.get(img_url)
            os.makedirs(os.path.dirname(save_path), exist_ok=True)

            if img_response.status_code == 200:
                with open(save_path, 'wb') as file:
                    file.write(img_response.content)
                print(f"Image successfully downloaded: {save_path}")
            else:
                print("Failed to download the image.")
        else:
            print("No image found on the page.")


def scrape(pages_number):
    headers = {
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3"
    }
    base_url = "https://wloczkiwarmii.pl/pl/10-wloczki"

    for page in range(1, pages_number+1):
        page_url = f"{base_url}?page={page}"
        print(f"Scraping page: {page_url}")

        product_urls = scrape_product_urls(page_url, headers)
        all_product_details = []

        for url in product_urls:
            details = scrape_product_details(url, headers)
            if details:
                all_product_details.append(details)

        print(f"Scraped {len(all_product_details)} products from page {page}.")
        save_to_json(all_product_details, page)
        for product in all_product_details:
            print(product)

        print("\n" + "=" * 40 + "\n")


if __name__ == "__main__":
    NUMBER_OF_PAGES_TO_SCRAPE = 21
    scrape(NUMBER_OF_PAGES_TO_SCRAPE)
