import random

from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC


class SearchByNameAndAddToCart:
    def __init__(self, website_addr, browser):
        self.website_url = website_addr
        self.browser = browser

    def run(self, name):
        self.browser.get(self.website_url)

        print(f"Searching for products with name: {name}")
        products = self.getProductsByName(name)
        product = self.getRandomProduct(products)

        print("Adding selected product to cart.")
        self.addProductToCart(product)
        print("Product has been successfully added to the cart.")

    def getProductsByName(self, name):
        search_icon = WebDriverWait(self.browser, 10).until(
            EC.element_to_be_clickable((By.CLASS_NAME, 'search-icon'))
        )
        search_icon.click()

        search_box = WebDriverWait(self.browser, 10).until(
            EC.visibility_of_element_located((By.NAME, 's'))
        )
        search_box.send_keys(name)
        search_box.send_keys(Keys.RETURN)

        WebDriverWait(self.browser, 10).until(
            EC.presence_of_element_located((By.CLASS_NAME, 'item-product'))
        )

        products = self.browser.find_elements(By.CLASS_NAME, 'thumbnail')
        products_flags = self.browser.find_elements(By.CLASS_NAME, 'product-flags')
        assert len(products_flags) == len(products)
        
        products_quantity = self.browser.find_elements(By.CLASS_NAME, 'hook-reviews')
        product_in_stock = []
        for idx in range(len(products_quantity)):
            if " 0" in products_quantity[idx].text:
                continue
            product_in_stock.append(products[idx])

        return product_in_stock

    def getRandomProduct(self, products):
        print("Random product selected.")
        return random.choice(products)

    def addProductToCart(self, product):
        product.click()

        WebDriverWait(self.browser, 10).until(
            EC.element_to_be_clickable((By.CLASS_NAME, 'add-to-cart'))
        )

        add_to_cart_button = self.browser.find_element(By.CLASS_NAME, 'add-to-cart')
        add_to_cart_button.click()

        WebDriverWait(self.browser, 10).until(
            EC.presence_of_element_located((By.CLASS_NAME, 'cart-products-count'))
        )
