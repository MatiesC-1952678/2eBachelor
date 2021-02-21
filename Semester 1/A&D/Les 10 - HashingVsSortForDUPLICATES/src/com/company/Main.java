package com.company;

import java.util.Arrays;

public class Main {
    public static void main(String[] args) {
        HeapSort hs = new HeapSort();
        int[] unsorted = hs.generate(false);
        long hashTime = 0;
        long heapTime = 0;
        for (int i = 0; i < 100; i++) {
            hashTime += hs.hash(unsorted);
            heapTime += hs.sort(unsorted);
            System.out.println("------");
        }
        System.out.println("average hash: "+(hashTime / 100.0f)+" miliseconds");
        System.out.println("average heap: "+(heapTime / 100.0f)+" miliseconds");
    }
}
