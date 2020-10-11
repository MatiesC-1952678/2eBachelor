# coding=utf-8
# This is a sample Python script.

# Press ⌃R to execute it or replace it with your code.
# Press Double ⇧ to search everywhere for classes, files, tool windows, actions, and settings.

from csv import writer
import time
import tracemalloc
from os import environ
from os.path import isfile


def monitor(func):
    def inner1(*args, **kwargs):
        # niet vertrouwd met `*args` en`*kwargs`
        # Kijk op https://realpython.com/python-kwargs-and-args/
        if not environ.get('MONITOR'):
            return func(*args, **kwargs)

        tracemalloc.start()  # start tracing memory allocation
        begin = time.time_ns()
        result = func(*args, **kwargs)
        end = time.time_ns()
        current, peak = tracemalloc.get_traced_memory()  # used memory sinds start trace
        tracemalloc.stop()
        if environ.get('MONITOR_FILE'):
            is_file = isfile(environ['MONITOR_FILE'])
            with open(environ['MONITOR_FILE'], 'a+', newline='') as write_obj:
                csv_writer = writer(write_obj)
                if not is_file:
                    csv_writer.writerow(['functie', 'context', 'runtime (ns)', 'current', 'peak'])
                csv_writer.writerow([func.__name__, environ.get('MONITOR_CONTEXT', ''), end-begin, current, peak])
        else:
            print(f"Total time taken in {func.__name__} is {end - begin}")
            print(f"Current and peak memory is {current} and {peak}")
        return result
    return inner1


def print_hi(name):
    # Use a breakpoint in the code line below to debug your script.
    print("Hi, {0}".format(name))  # Press ⌘F8 to toggle the breakpoint.

@monitor
def fib_it(n):
    if n == 0:
        return 0
    if n == 1:
        return 1

    prev = 1
    last = 1
    for x in range(2, n):
        temp = last
        last = prev + last
        prev = temp
    return last

@monitor
def call_fib_rec(n):
    return fib_rec(n)

def fib_rec(n):
    if n == 0:
        return 0
    if n == 1:
        return 1
    return fib_rec(n-1)+fib_rec(n-2)

def test_fib_it(input: int, expected: int):
    assert fib_it(input) == expected

# Press the green button in the gutter to run the script.
if __name__ == '__main__':
    for i in range(0, 11):
        print(fib_it(i), end='\t')
        print(call_fib_rec(i))

    # Unit tests
    test_fib_it(0, 0)
    test_fib_it(1, 1)
    test_fib_it(2, 1)
    test_fib_it(3, 2)
    test_fib_it(4, 3)
    test_fib_it(5, 5)
    test_fib_it(6, 8)
    test_fib_it(10, 55)


# See PyCharm help at https://www.jetbrains.com/help/pycharm/
