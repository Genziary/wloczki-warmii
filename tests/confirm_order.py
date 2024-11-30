from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

class AdminOrderConfirmation:
    def __init__(self, admin_url, browser, admin_email, admin_password):
        self.admin_url = admin_url
        self.browser = browser
        self.admin_email = admin_email
        self.admin_password = admin_password

    def run(self):
        try:
            self.browser.get(self.admin_url)

            WebDriverWait(self.browser, 10).until(EC.presence_of_element_located((By.ID, 'email')))
            email_input = self.browser.find_element(By.ID, 'email')
            email_input.send_keys(self.admin_email)

            password_input = self.browser.find_element(By.ID, 'passwd')
            password_input.send_keys(self.admin_password)
            password_input.send_keys(Keys.RETURN)

            WebDriverWait(self.browser, 10).until(EC.presence_of_element_located((By.ID, 'main')))

            orders_menu = WebDriverWait(self.browser, 10).until(
                EC.element_to_be_clickable((By.CSS_SELECTOR, 'li#subtab-AdminParentOrders a'))
            )
            orders_menu.click()

            orders_link = WebDriverWait(self.browser, 10).until(
                EC.element_to_be_clickable((By.CSS_SELECTOR, 'li#subtab-AdminOrders a'))
            )
            orders_link.click()

            WebDriverWait(self.browser, 10).until(EC.presence_of_element_located((By.CSS_SELECTOR, 'table.table')))

            dropdown_button = WebDriverWait(self.browser, 10).until(
                EC.element_to_be_clickable((By.CLASS_NAME, "column-osname"))
            )
            dropdown_button.click()

            option_value_2 = WebDriverWait(self.browser, 10).until(
                EC.element_to_be_clickable((By.CSS_SELECTOR, "button[data-value='2']"))
            )
            option_value_2.click()

        except Exception as e:
            print(f"Wystąpił błąd: {e}")
