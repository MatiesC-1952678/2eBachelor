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
