import time
from selenium import webdriver

from selenium.webdriver.chrome.options import Options
from add_products_to_cart import AddRandomProductsToCart
from search_by_name import SearchByNameAndAddToCart
from delete_products_from_cart import DeleteProductsFromCart
from create_new_account import CreateNewAccount
from place_order import PlaceOrder
from confirm_order import AdminOrderConfirmation
from check_status_and_download_invoice import CheckOrderStatusAndDownloadInvoice

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

    # Search for product by name and add random product to the cart from among those found
    search_by_name_and_add_to_cart = SearchByNameAndAddToCart(url, browser)
    search_by_name_and_add_to_cart.run("alpaka")

    # Remove 3 products from the cart
    delete_products_from_cart = DeleteProductsFromCart(url + cart, browser, 3)
    delete_products_from_cart.run()

    # Create new account
    create_new_account = CreateNewAccount(url + register, browser)
    create_new_account.run()

    # Place orders for cart contents + Choose payment method: upon delivery + Choose one carrier
    place_order = PlaceOrder(url, browser)
    place_order.run()

    # Confirm order
    admin_order = AdminOrderConfirmation(admin_url="http://localhost:8000/admin-dev", browser=browser, admin_email="admin@wloczki.pl", admin_password="123123123")
    admin_order.run()

    # Check order status + Download VAT invoice
    check_order_status_and_download = CheckOrderStatusAndDownloadInvoice(url + account, browser)
    check_order_status_and_download.run()

    end_time = time.time()
    elapsed_time = end_time - start_time

    print(f"Execution time: {elapsed_time} seconds")
    input()
