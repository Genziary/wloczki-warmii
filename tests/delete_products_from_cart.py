import random

from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC


class DeleteProductsFromCart:
    def __init__(self, website_url, browser, number_of_products):
        self.website_url = website_url
        self.browser = browser
        self.number_of_products = number_of_products

    def run(self):
        links_of_products_to_delete = self.getLinksToDeleteProductsFromCart()
        for link in links_of_products_to_delete:
            self.browser.get(link)

    def getLinksToDeleteProductsFromCart(self):
        self.browser.get(self.website_url)

        WebDriverWait(self.browser, 10).until(
            EC.presence_of_element_located((By.CLASS_NAME, 'remove-from-cart'))
        )

        products = self.browser.find_elements(By.CLASS_NAME, 'remove-from-cart')
        product_links = [element.get_attribute("href") for element in products]

        return random.sample(product_links, k=self.number_of_products)
