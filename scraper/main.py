import requests
from bs4 import BeautifulSoup
from utils import extract_numerical_value, extract_numerical_integer_value, fill_weight_numbers


def get_dynamic_prices(headers, all_weights, default_url):
    """
    Function to scrape product prices at different weights
    """

    splitted_route = default_url.split("/")

    product_params = splitted_route[5].split("-")
    weight_number = int(product_params[1])

    default_weight = int(splitted_route[-1].split("-")[0])

    weight_numbers = [0 for _ in all_weights]
    default_index = 0
    for index, weight_value in enumerate(all_weights.keys()):
        if weight_value == default_weight:
            weight_numbers[index] = weight_number
            default_index = index

    weight_numbers = fill_weight_numbers(weight_numbers, default_index)
    brutto_prices = []
    netto_prices = []

    for index, weight in enumerate(all_weights.keys()):
        product_params[1] = weight_numbers[index]
        weight_desc = f"{weight}-waga-{all_weights[weight]}"
        joined_params = "-".join(map(str, product_params))
        splitted_route[5] = joined_params
        splitted_route[-1] = weight_desc
        joined_route = "/".join(map(str, splitted_route))

        response = requests.get(url=joined_route, headers=headers)
        product_soup = BeautifulSoup(response.content, "html.parser")
        brutto_price = product_soup.find("span", itemprop="price").get_text(strip=True)
        netto_price = product_soup.find("div", class_="tax-shipping-delivery-label").get_text(strip=True)
        brutto_prices.append(extract_numerical_value(brutto_price))
        netto_prices.append(extract_numerical_value(netto_price))

    return brutto_prices, netto_prices


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
        index = product_info_div.find("p").get_text(strip=True)

        weight_select = product_soup.find("select", {"id": "group_7"})
        product_prices = {}

        brutto_prices = []
        netto_prices = []

        if weight_select:
            html_weight_options = weight_select.find_all("option")
            weights_map = {}

            for option in html_weight_options:
                weight = extract_numerical_integer_value(option["title"])
                weights_map[int(option["value"])] = weight
            brutto_prices, netto_prices = get_dynamic_prices(headers, weights_map, product_url)
        else:
            # If the weight selection form does not exist, get the price directly
            brutto_price = product_soup.find("span", itemprop="price").get_text(strip=True)
            netto_price = product_soup.find("div", class_="tax-shipping-delivery-label").get_text(strip=True)
            brutto_prices.append(extract_numerical_value(brutto_price))
            netto_prices.append(extract_numerical_value(netto_price))

        product_prices["brutto"] = brutto_prices
        product_prices["netto"] = netto_prices

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


headers = {
    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3"
}
base_url = "https://wloczkiwarmii.pl/pl/10-wloczki"


for page in range(1, 2):
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
