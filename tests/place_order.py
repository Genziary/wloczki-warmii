from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC


class PlaceOrder:
    def __init__(self, website_url, browser):
        self.website_url = website_url
        self.browser = browser

    def run(self):
        self.browser.get(self.website_url)
        self.go_to_cart()
        self.place_order()

    def go_to_cart(self):
        WebDriverWait(self.browser, 10).until(
            EC.element_to_be_clickable((By.CLASS_NAME, 'cart-preview'))
        )

        self.browser.find_element(By.CLASS_NAME, 'cart-preview').click()

    def place_order(self):
        button = self.browser.find_element(By.XPATH, '//a[contains(@href, "/zamówienie") and contains(@class, "btn-primary")]')
        button.click()

        WebDriverWait(self.browser, 10).until(
            EC.presence_of_element_located((By.CLASS_NAME, 'continue'))
        )

        self.set_delivery_info()
        self.choose_carrier()
        self.choose_payment_option()

    def set_delivery_info(self):
        self.browser.find_element(By.ID, 'field-address1').send_keys('Klonowa 10')
        self.browser.find_element(By.ID, 'field-postcode').send_keys('00-000')
        self.browser.find_element(By.ID, 'field-city').send_keys('Warszawa')
        self.browser.find_element(By.NAME, 'confirm-addresses').click()

        WebDriverWait(self.browser, 10).until(
            EC.presence_of_element_located((By.CLASS_NAME, 'continue'))
        )

    def choose_carrier(self):
        self.browser.find_element(By.ID, 'delivery_option_7').click()
        self.browser.find_element(By.NAME, 'confirmDeliveryOption').click()

        WebDriverWait(self.browser, 10).until(
            EC.presence_of_element_located((By.ID, 'payment-confirmation'))
        )

    def choose_payment_option(self):
        self.browser.find_element(By.ID, 'conditions_to_approve[terms-and-conditions]').click()

        WebDriverWait(self.browser, 10).until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, ".btn.btn-primary.center-block"))
        )
        self.browser.find_element(By.CSS_SELECTOR, ".btn.btn-primary.center-block").click()