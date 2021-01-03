from monitor import monitor
import random

def makeList(n):
    list = []
    for i in range(n, 0, -1):
        list.append(i)
    return list

def test(list):
    return list

def makeListRand(n):
    list = []
    for i in range(0, n):
        list.append(random.randrange(n))
    return list

def swap(l, ind1, ind2):
    temp = l[ind1]
    l[ind1] = l[ind2]
    l[ind2] = temp
    return l

@monitor
#basic bubblesort implemented from the book
def bubbleSort(a):
    n = len(a)-1
    for i in range(0, n):
        for j in range(n, i, -1):
            if a[j-1] > a[j]:
                a = swap(a, j-1, j)
    return a

@monitor
#bubblesort zonder vanaf reeds gesorteerde deel te beginnen
def bubbleSort_alt_2(a):
    n = len(a)-1
    for i in range(0, n):
        for j in range(n, 0, -1):
            if a[j-1] > a[j]:
                a = swap(a, j-1, j)
    return a

def isCorrect(a, len):
    for i in range(0, len):
        if (a[i] > a[i+1]):
            return False
    return True

@monitor
#bubblesort bekijkt als deze al gesorteerd is
def bubbleSort_alt_1(a):
    n = len(a)-1
    for i in range(0, n):
        if (not isCorrect(a, n)): #zeer slecht
            for j in range(n, i, -1):
                if a[j-1] > a[j]:
                    a = swap(a, j-1, j)
    return a

@monitor
#werkt veel beter dan alt_1 normaal gezien
def bubbleSort_alt_1_2(a):
    n = len(a)-1
    for i in range(0, n):
        swapped = False
        for j in range(n, i, -1):
            if a[j-1] > a[j]:
                a = swap(a, j-1, j)
                swapped = True
        if not swapped:
            return a
    return a

@monitor
#werkt veel beter dan alt_1 normaal gezien
def bubbleSort_alt_2_2(a):
    n = len(a)-1
    for i in range(0, n):
        swapped = False
        for j in range(n, i, -1):
            if a[j-1] > a[j]:
                a = swap(a, j-1, j)
                swapped = True
        if not swapped:
            return a
    return a


@monitor
#werkt veel beter dan alt_1 normaal gezien
def bubbleSort_fin(a):
    n = len(a)-1
    for i in range(0, n):
        swapped = False
        for j in range(n, i, -1):
            if a[j-1] > a[j]:
                a = swap(a, j-1, j)
                swapped = True
        if not swapped:
            return a
    return a

if __name__ == '__main__':
    # list = [1, 4, 2, 2, 4, 6, 9]
    # print(bubbleSort(list))
    # print(bubbleSort_alt_1(list))
    # print(bubbleSort_alt_2(list))
    # list = [9, 6, 3, 5, 4, 8, 5, 2]
    # print(bubbleSort(list))
    # print(bubbleSort_alt_1(list))
    # print(bubbleSort_alt_2(list))
    # list = [9, 6, 3, 5, 4, 8, 5, 2, 5, 3, 4, 6, 2, 5, 6, 7, 8, 8, 8, 5, 4, 3, 2, 5]
    # print(bubbleSort(list))
    # print(bubbleSort_alt_1(list))
    # print(bubbleSort_alt_2(list))
    list = makeListRand(1000)
    #time.sleep(2)
    #bubbleSort_alt_1(list)
    #bubbleSort(list)
    #bubbleSort_alt_2(list)
    test(list)
    bubbleSort_fin(list)