package com.company;

class print25Ints {
    public void print() {
        int prev = 0;
        System.out.println("num:" + prev);
        for (int i = 0; i < 25; i++) {
            int now = (int) (Math.random() * 1000);
            if (now > prev) {
                System.out.println("num:" + now + "\t\tgreater than");
            } else if (now == prev) {
                System.out.println("num:" + now + "\t\tequal to");
            } else {
                System.out.println("num:" + now + "\t\tless than");
            }
            prev = now;
        }
    }
}

class findPrimes {
    public void find(int max) {
        for(int i = max; i > 1; i--) {
            boolean isPrime = true;
            for (int j = i-1; j > 1; j--) {
                if (i % j == 0) {
                    isPrime = false;
                    break;
                }
            }
            if (isPrime)
                System.out.println(i);
        }
    }
}

public class Main {
    public static void main(String[] args) {
        print25Ints objOne = new print25Ints();
        objOne.print();
        findPrimes objTwo = new findPrimes();
        objTwo.find(100);
    }
}
