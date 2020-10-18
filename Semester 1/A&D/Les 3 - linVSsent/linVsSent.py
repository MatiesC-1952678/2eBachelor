from monitor import monitor

@monitor
def linSearch(e, v):
    i = 0
    N = len(v)
    while i < N and v[i] != e:
        i += 1
    if i < N:
        return i
    else:
        return "niet gevonden"

def swapLast (v, h):
    temp = v[len(v)-1]
    v[len(v)-1] = h
    h = temp
    return v

@monitor
def senSearch(e, v):
    h = e
    v = swapLast(v, h)
    i = 0
    while v[i] != e:
        i += 1
    v = swapLast(v, h)
    if v[i] == e:
        return i
    else:
        return "niet gevonden"

def makeList(size):
    millions = range(1, size)
    list = []
    for million in millions:
        list.append(million)
    return list


if __name__ == '__main__':
    #list = [2, 1, 25, 3]
    #print(linSearch(3, list))
    #print(senSearch(3, list))
    #list = [2, 1, 25, 4, 5, 6, 7, 8, 9, 10, 2, 2, 3, 4, 5, 3, 2, 1, 3, 9, 43, 5, 6, 6, 10]
    #print(linSearch(10, list))
    #print(senSearch(10, list))
    #print(linSearch(43, list))
    #print(senSearch(43, list))
    print (linSearch(1000000, makeList(1000001)))
    print (senSearch(1000000, makeList(1000001)))


