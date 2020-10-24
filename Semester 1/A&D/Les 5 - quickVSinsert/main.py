import random
from monitor import monitor

def makeList(n):
    list = []
    for i in range(n, 0, -1):
        list.append(i)
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

def isCorrect(a):
    for i in range(0, len(a)-2):
        if a[i] > a[i+1]:
            return False
    return True

@monitor
def insertionSort(a):
    n = len(a)
    placefound = False
    for i in range(1, n):
        insert = a[i]
        place = i
        placefound = insert >= a[place - 1]
        if not placefound:
            a[place] = a[place - 1]
            place = place - 1
        while not placefound and place > 0:
            placefound = insert >= a[place - 1]
            if not placefound:
                a[place] = a[place - 1]
                place = place - 1
        a[place] = insert
    #print(a)
    return a


@monitor
def quickSort(a):
    partition(0, len(a)-1, a)

def quickSortTest(a):
    print("input:\t", end="")
    print(a)
    partition(0, len(a) - 1, a)
    print("output:\t", end="")
    print(a)
    print(isCorrect(a))
    assert isCorrect(a) == True

def partition(l, r, a):
    i = l
    j = r
    spil = a[int((l+r)/2)]
    while i <= j:
        while a[i] < spil:
            i += 1
        while a[j] > spil:
            j -= 1
        if i <= j:
            a = swap(a, i, j)
            i += 1
            j -= 1
    if l < j:
        partition(l, j, a)
    if i < r:
        partition(i, r, a)

def insAndQuickSort(a):
    if len(a) < 20:
        insertionSort(a)
    else:
        altQuickSort(0, len(a)-1, a)
    #print(a)
    #print(isCorrect(a))

def altQuickSort(x, y, a):
    i = x
    j = y
    spil = a[int((x+y)/2)]
    while i <= j:
        while a[i] < spil:
            i += 1
        while a[j] > spil:
            j -= 1
        if i <= j:
            a = swap(a, i, j)
            i += 1
            j -= 1
    if x < j:
        partition(x, i, a)
    if i < y:
        partition(j, y, a)

if __name__ == '__main__':
    a = makeListRand(100)
    #insertionSort(a)
    #quickSort(a)
    insAndQuickSort(a)
