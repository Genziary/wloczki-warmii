from selenium.common import NoSuchElementException
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC


class CheckOrderStatusAndDownloadInvoice:
    def __init__(self, website_url, browser):
        self.website_url = website_url
        self.browser = browser

    def run(self):
        print("Starting order status check and invoice download process.")
        self.browser.get(self.website_url)
        self.go_to_orders_history()
        self.go_to_order_details()
        self.download_invoice()
        print("Process completed.")

    def _go_to_account(self):
        print("Navigating to user account.")
        WebDriverWait(self.browser, 10).until(
            EC.element_to_be_clickable((By.XPATH, '//div[contains(@class, "user-info-block")]//div[contains(@class, "localiz_block")]'))
        )

        self.browser.find_element(By.XPATH, '//div[contains(@class, "user-info-block")]//div[contains(@class, "localiz_block")]').click()

    def go_to_orders_history(self):
        WebDriverWait(self.browser, 10).until(
            EC.element_to_be_clickable((By.ID, 'history-link'))
        )

        self.browser.find_element(By.ID, 'history-link').click()
        print("Orders history page loaded.")

    def go_to_order_details(self):
        WebDriverWait(self.browser, 10).until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, "a[data-link-action=\"view-order-details\"]"))
        )

        self.browser.find_element(By.CSS_SELECTOR, "a[data-link-action=\"view-order-details\"]").click()
        print("Order details page loaded.")

    def download_invoice(self):
        print("Attempting to download invoice.")
        WebDriverWait(self.browser, 10).until(
            EC.presence_of_element_located((By.ID, 'order-infos'))
        )

        order_infos_div = self.browser.find_element(By.ID, 'order-infos')
        li_elements = order_infos_div.find_elements(By.CSS_SELECTOR, '.box > ul > li')
        for li_element in li_elements:
            try:
                a_element = li_element.find_element(By.TAG_NAME, 'a')
                href_value = a_element.get_attribute('href')
                self.browser.get(href_value)
                print("Invoice downloaded successfully.")
                return
            except NoSuchElementException as e:
                continue

        print("Invoice not found.")
