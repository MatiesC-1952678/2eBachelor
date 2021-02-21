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



if __name__ == '__main__':
    a = makeListRand(10)
    quickSort(a)
