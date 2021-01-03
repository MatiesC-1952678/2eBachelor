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

@monitor
def shakerSort(a):
    n = len(a)-1
    for i in range(0, n):
        swapped = False
        for j in range(n-i, i, -1):
            if a[j-1] > a[j]:
                #print(str(a[j-1])+" > "+str(a[j]))
                a = swap(a, j-1, j)
                swapped = True
        for k in range(i+1, n-i):
            if a[k+1] < a[k]:
                #print(str(a[k+1])+" < "+str(a[k]))
                a = swap(a, k+1, k)
                swapped = True
        if not swapped:
            return a
    return a

if __name__ == '__main__':
    list = makeListRand(1000)
    shakerSort(list)