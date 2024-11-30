import time
from selenium import webdriver

from selenium.webdriver.chrome.options import Options
from add_products_to_cart import AddRandomProductsToCart

url = "https://localhost:8443/"
all_products = "pl/61-wloczki?"
cart = "koszyk?action=show"
register = "logowanie?create_account=1"
account = "moje-konto"

if __name__ == '__main__':

    start_time = time.time()
    options = Options()
    options.add_argument('--ignore-certificate-errors')
    options.add_argument('--ignore-ssl-errors')
    options.add_argument('--start-maximized')
    browser = webdriver.Chrome(options=options)

    # Add 10 products (in different quantities) from two different categories to the cart
    add_x_random_from_y_categories_to_cart = AddRandomProductsToCart(url + all_products, browser, 10)
    add_x_random_from_y_categories_to_cart.run()

    end_time = time.time()
    elapsed_time = end_time - start_time

    print(f"Execution time: {elapsed_time} seconds")
    input()
