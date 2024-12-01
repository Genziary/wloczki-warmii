import uuid

from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC


class CreateNewAccount:
    def __init__(self, website_addr, browser):
        self.website_url = website_addr
        self.browser = browser

    def run(self):
        print("Starting process of creating new account.")
        self.browser.get(self.website_url)

        WebDriverWait(self.browser, 10).until(
            EC.presence_of_element_located((By.CLASS_NAME, 'form-control-submit'))
        )

        print("Filling out account creation form.")
        self.browser.find_element(By.CSS_SELECTOR, "input[value=\"1\"]").click()
        self.browser.find_element(By.CSS_SELECTOR, "input[name=\"firstname\"]").send_keys("Uzytkownik")
        self.browser.find_element(By.CSS_SELECTOR, "input[name=\"lastname\"]").send_keys("Testowy")
        self.browser.find_element(By.CSS_SELECTOR, "input[name=\"email\"]").send_keys(
            "testowy" + str(uuid.uuid4()) + "@gmail.com")
        self.browser.find_element(By.CSS_SELECTOR, "input[name=\"password\"]").send_keys("testtest")

        WebDriverWait(self.browser, 10).until(
            EC.presence_of_element_located((By.NAME, 'customer_privacy'))
        )

        print("Accepting terms and conditions.")
        self.browser.find_element(By.NAME, 'customer_privacy').click()
        self.browser.find_element(By.NAME, 'customer_privacy').click()
        self.browser.find_element(By.CSS_SELECTOR, "input[name=\"psgdpr\"]").click()
        self.browser.find_element(By.CLASS_NAME, 'form-control-submit').click()

        print("Account creation process completed.")
