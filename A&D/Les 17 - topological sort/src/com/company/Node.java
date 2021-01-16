package com.company;

import java.util.ArrayList;

public class Node {
    private ArrayList<Node> nodes = new ArrayList<>();
    private int order;
    static int orderCounter = 0;

    /**
     * called on root
     */
    public void topologicalSort() {
        order = orderCounter++;
        for (Node n : nodes) {
            n.topologicalSort();
        }
    }

    public void addChild(Node child) {
        nodes.add(child);
    }
}
