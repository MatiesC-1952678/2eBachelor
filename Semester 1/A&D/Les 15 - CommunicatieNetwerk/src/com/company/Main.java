package com.company;

public class Main {

    public static void main(String[] args) {
        Node a = new Node((float) 0.9, "a");
        Node b = new Node((float) 0.6, "b");
        Node c = new Node((float) 0.7, "c");
        a.addConnection(b);
        b.addConnection(c);
        c.addConnection(a);
    }
}
