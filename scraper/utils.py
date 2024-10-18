import re


def extract_numerical_value(text):
    """
    Extract the single numerical value from a given text.
    Args:
        text (str): The input string containing the price.

    Returns:
        float: The extracted numerical value. Returns None if not found.
    """
    # find a number including decimals(e.g., "70.73", "100,00")
    number_match = re.search(r'(\d+[.,]?\d*)', text)

    if number_match:
        value = number_match.group(1).replace(',', '.')
        return float(value)
    return None
