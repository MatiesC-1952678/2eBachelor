package com.company;

public class Main {

    public static void main(String[] args) {
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
