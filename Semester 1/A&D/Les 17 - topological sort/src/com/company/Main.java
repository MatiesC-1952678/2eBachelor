package com.company;

public class Main {
    public static void main(String[] args) {

        Node e = new Node();
        Node f = new Node();
        Node g = new Node();
        Node c = new Node();
        Node b = new Node();
        Node a = new Node();
        Node d = new Node();
        e.addChild(f);
        e.addChild(g);
        f.addChild(g);
        f.addChild(c);
        c.addChild(g);
        b.addChild(a);
        b.addChild(c);
        a.addChild(d);
        d.addChild(c);
        e.topologicalSort();
        b.topologicalSort();
        
    }
}
