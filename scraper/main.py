import requests
import os
from bs4 import BeautifulSoup
from utils import extract_numerical_value, extract_numerical_integer_value, benchmark

MEDIA_FOLDER = os.path.join(os.getcwd(), 'media')


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

        weight_select = product_soup.find("select", {"id": "group_7"})
        length_select = product_soup.find("select", {"id": "group_5"})
        outcolor_select = product_soup.find("select", {"id": "group_6"})

        product_prices = {}
        brutto_prices = []
        netto_prices = []
        weights = []
        variants = {}

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

        save_image(product_soup, product_id)
        return {
            "categories_tree": categories_tree,
            "index": index,
            "prices": product_prices
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


def save_image(soup, product_id):
    save_path = os.path.join(MEDIA_FOLDER, f'{product_id}.jpg')
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
        for product in all_product_details:
            print(product)

        print("\n" + "=" * 40 + "\n")


if __name__ == "__main__":
    NUMBER_OF_PAGES_TO_SCRAPE = 22
    scrape(NUMBER_OF_PAGES_TO_SCRAPE)
