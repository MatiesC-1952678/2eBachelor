from monitor import monitor

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

    #for i in range(0, 11):
    #    print(fib_it(i), end='\t')
    #    print(call_fib_rec(i))

    print(fib_it(10), end='\t')
    print(call_fib_rec(10))

    # Unit tests
    #test_fib_it(0, 0)
    #test_fib_it(1, 1)
    #test_fib_it(2, 1)
    #test_fib_it(3, 2)
    #test_fib_it(4, 3)
    #test_fib_it(5, 5)
    #test_fib_it(6, 8)
    #test_fib_it(10, 55)


# See PyCharm help at https://www.jetbrains.com/help/pycharm/
