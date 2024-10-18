import requests
from bs4 import BeautifulSoup


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
        index = product_info_div.find("p")

        return {
            "categories_tree": categories_tree,
            "index": index
        }
    else:
        print(f"Failed to retrieve product page: {product_url}. Status code: {product_response.status_code}")
        return None


def scrape_products_from_listing(listing_url):
    """
    Function to scrape product URLs from the listing page and call another function to scrape details from each product page.
    """
    headers = {
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3"
    }

    response = requests.get(listing_url, headers=headers)
    if response.status_code == 200:
        print("Main page successfully retrieved!")
        
        soup = BeautifulSoup(response.content, "html.parser")
        products = soup.find_all("a", class_="thumbnail product-thumbnail")
        product_data = []
        
        for product in products:
            product_url = product.get("href")
            print(f"Scraping product page: {product_url}")
            
            details = scrape_product_details(product_url, headers)
            if details:
                product_data.append(details)
        
        return product_data
    else:
        print(f"Failed to retrieve the main page. Status code: {response.status_code}")
        return None


listing_url = "https://wloczkiwarmii.pl/pl/10-wloczki"
products_info = scrape_products_from_listing(listing_url)

if products_info:
    for product in products_info:
        print(product)
        print("-" * 40)
