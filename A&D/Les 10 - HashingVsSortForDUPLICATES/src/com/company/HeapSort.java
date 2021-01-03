package com.company;

import java.util.HashMap;
import java.util.Random;

// Java program for implementation of Heap Sort
public class HeapSort {

    Integer universum = 1000;
    int size = 1000;

    // ---------------------- my code ^

    public long sort(int arr[])
    {
        long startTime = System.currentTimeMillis();
        int n = arr.length;

        // Build heap (rearrange array)
        for (int i = n / 2 - 1; i >= 0; i--)
            heapify(arr, n, i);

        // One by one extract an element from heap
        for (int i = n - 1; i > 0; i--) {
            // Move current root to end
            int temp = arr[0];
            arr[0] = arr[i];
            arr[i] = temp;

            // call max heapify on the reduced heap
            heapify(arr, i, 0);
        }
        //System.out.println("" + Runtime.getRuntime().freeMemory());
        int[] result = deleteDoubles(arr);
        long endTime = System.currentTimeMillis();
        long time = (endTime - startTime);
        System.out.println("Heap: That took " + time + " milliseconds");

        return time;
    }

    // To heapify a subtree rooted with node i which is
    // an index in arr[]. n is size of heap
    void heapify(int arr[], int n, int i)
    {
        int largest = i; // Initialize largest as root
        int l = 2 * i + 1; // left = 2*i + 1
        int r = 2 * i + 2; // right = 2*i + 2

        // If left child is larger than root
        if (l < n && arr[l] > arr[largest])
            largest = l;

        // If right child is larger than largest so far
        if (r < n && arr[r] > arr[largest])
            largest = r;

        // If largest is not root
        if (largest != i) {
            int swap = arr[i];
            arr[i] = arr[largest];
            arr[largest] = swap;

            // Recursively heapify the affected sub-tree
            heapify(arr, n, largest);
        }
    }

    private int[] deleteDoubles(int[] sorted) {
        int[] doublesDeleted = new int[universum];
        int temp = -1;
        int index = 0;
        for (int i: sorted) {
            if (temp != i) {
                doublesDeleted[index++] = i;
                temp = i;
            }
        }
        return doublesDeleted;
    }


    // ---------------------- my code v

    public int[] generate(boolean isRune) {
        int[] result = new int[size];
        for(int i = 0; i < size; i++) {
            if (!isRune)
                result[i] = (int) (Math.random() * (universum));
            else {
                Random r = new Random();
                int low = 0;
                int high = universum;
                result[i] = ((r.nextInt(high - low)) + low);
            }
        }
        return result;
    }


    public long hash(int[] unorderedList) {
        long startTime = System.currentTimeMillis();

        HashMap<Integer, Integer> hashTable = new HashMap<>();
        for (int i : unorderedList) {
            if (hashTable.get(i) == null)
                hashTable.put(hashFunctie(i), i);
        }

        //System.out.println("" + Runtime.getRuntime().freeMemory());
        long endTime = System.currentTimeMillis();
        long time = (endTime - startTime);
        System.out.println("Hash: That took " + time + " milliseconds");

        return time;
    }

    private Integer hashFunctie(Integer value) {
        try {
            if (value >= universum)
                throw new Exception();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return value;
    }
}
