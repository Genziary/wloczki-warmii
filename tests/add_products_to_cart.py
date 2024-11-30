import time
import random

from selenium.common import TimeoutException
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC


class AddRandomProductsToCart:
    def __init__(self, website_url, browser, products_number):
        self.webiste_url = website_url
        self.browser = browser
        self.products_number = products_number

        self.categories = [
            '&q=Kategorie-COTTONMIX+CAKE',
            '&q=Kategorie-WEŁNA+100%25'
        ]
        products_per_category = random.randint(1, 9)
        self.number_of_products_from_categories = [products_per_category, 10 - products_per_category]

    def run(self):
        products_links_category_first = self.getProductsLinks(self.webiste_url + self.categories[0],
                                                               self.number_of_products_from_categories[0])
        products_links_category_second = self.getProductsLinks(self.webiste_url + self.categories[1],
                                                                self.number_of_products_from_categories[1])

        for product_link in products_links_category_first:
            self.addProductToCartRandomQuantity(product_link)

        for product_link in products_links_category_second:
            self.addProductToCartRandomQuantity(product_link)

    def getProductsLinks(self, addr, num):
        self.browser.get(addr)

        WebDriverWait(self.browser, 10).until(
            EC.presence_of_element_located((By.CLASS_NAME, 'item-product'))
        )

        products = self.browser.find_elements(By.CLASS_NAME, 'thumbnail')
        products_flags = self.browser.find_elements(By.CLASS_NAME, 'product-flags')
        assert len(products_flags) == len(products)

        products_quantity = self.browser.find_elements(By.CLASS_NAME, 'hook-reviews')
        product_links = []
        for idx in range(len(products_quantity)):
            if " 0" in products_quantity[idx].text:
                continue
            product_links.append(products[idx].get_attribute("href"))

        return random.sample(product_links, k=num)

    def addProductToCartRandomQuantity(self, product_link):
        self.browser.get(product_link)

        WebDriverWait(self.browser, 10).until(
            EC.element_to_be_clickable((By.CLASS_NAME, 'form-control'))
        )

        try:
            _ = WebDriverWait(self.browser, 0.1).until(
                EC.element_to_be_clickable((By.CLASS_NAME, 'add-to-cart'))
            )
        except TimeoutException:
            customization_box = self.browser.find_element(By.CLASS_NAME, 'product-message')
            customization_box.send_keys("Selenium test")

            submit_customization = self.browser.find_element(By.NAME, 'submitCustomizedData')
            submit_customization.click()

        try:
            WebDriverWait(self.browser, 0.1).until(
                EC.presence_of_element_located((By.XPATH, "//div[contains(@class, 'product-quantities')]/span"))
            )
            available_quantity = self.browser.find_element(By.XPATH, "//div[contains(@class, 'product-quantities')]/span")
            available_quantity = available_quantity.text.split()[0]
        except TimeoutException:
            available_quantity = 1

        quantity_box = self.browser.find_element(By.NAME, 'qty')
        quantity_box.send_keys(Keys.DELETE)
        t = random.randint(1, int(available_quantity))
        quantity_box.send_keys(t)

        add_to_cart_button = self.browser.find_element(By.CLASS_NAME, 'add-to-cart')
        add_to_cart_button.click()

        WebDriverWait(self.browser, 10).until(
            EC.presence_of_element_located((By.CLASS_NAME, 'cart-products-count'))
        )