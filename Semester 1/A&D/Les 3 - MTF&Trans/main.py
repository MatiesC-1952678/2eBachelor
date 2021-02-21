from monitor import monitor

import collections

@monitor
def move_to_front_c(e, v: collections.deque):
    eFound = v.count(e)
    counter = eFound
    while counter != 0:
        counter -= 1
        v.remove(e)
        v.appendleft(e)
    print(v)

@monitor
def move_to_front_a(e, v):
    output = []
    eFound = 0
    for i in range(0, len(v)):
        if e != v[i]:
            output.append(v[i])
        else:
            eFound += 1
    listFound = []
    for i in range(0, eFound):
        listFound.append(e)
    listFound.extend(output)
    print(listFound)

#@monitor
#def transpose_c(e, v):
#    for i in range(0, len(v)):
#        if e == v[i]:

if __name__ == '__main__':
    collDeque = collections.deque([3, 4, 1, 4, 3, 4, 1, 5, 7])
    array = [3, 4, 1, 4, 3, 4, 1, 5, 7]
    move_to_front_c(1, collDeque)
    move_to_front_a(1, array)