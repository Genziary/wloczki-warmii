import re
import time


def fill_weight_numbers(weight_numbers, non_zero_index):
    """
    Fills an array with values based on a single non-zero element.

    Args:
        weight_numbers (list): List of numbers, where only one element is non-zero.
        non_zero_index (int): Index of the non-zero element in the list.

    Returns:
        list: The array filled with arithmetic values based on the non-zero element.
    """
    # O(n) for filling

    non_zero_value = weight_numbers[non_zero_index]

    print(weight_numbers)

    for i in range(non_zero_index - 1, -1, -1):
        weight_numbers[i] = non_zero_value - (non_zero_index - i)

    for i in range(non_zero_index + 1, len(weight_numbers)):
        weight_numbers[i] = non_zero_value + (i - non_zero_index)

    return weight_numbers


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


def extract_numerical_integer_value(text):
    """
    Extract the single integer value from a given text.

    Args:
        text (str): The input string containing the number.

    Returns:
        int: The extracted numerical integer value. Returns None if not found.
    """
    # find a whole number (e.g., "70", "100")
    number_match = re.search(r'\d+', text)

    if number_match:
        return int(number_match.group(0))  # return the integer value
    return None


def benchmark(func):
    def wrapper(*args, **kwargs):
        start_time = time.time()
        result = func(*args, **kwargs)
        end_time = time.time()
        execution_time = end_time - start_time
        print(f"Benchmark: {func.__name__} executed in {execution_time:.4f} seconds")
        return result
    return wrapper
