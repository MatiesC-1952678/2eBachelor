from monitor import monitor
import random

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

def selectionSort(a):
    n = len(a)
    for i in range(1, n):
        min = a[i-1]
        minInd = i-1
        for j in range(i, n):
            if min > a[j]:
                min = a[j]
                minInd = j
        a = swap(a, i-1, minInd)
    print(a)
    return a

if __name__ == '__main__':
    selectionSort(makeListRand(100))


