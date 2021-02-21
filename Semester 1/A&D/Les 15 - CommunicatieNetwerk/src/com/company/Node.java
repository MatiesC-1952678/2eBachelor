package com.company;

import java.util.ArrayList;

public class Node {
    private String name;
    private Float chance;
    private ArrayList<Node> connections;
    boolean visited = false;

    private ArrayList<Node> S = new ArrayList<>();
    private ArrayList<Node> D = new ArrayList<>();

    public Node(Float chance, String name) {
        this.name = name;
        this.chance = chance;
    }

    public void addConnection(Node n) {
        connections.add(n);
    }

    /**
     * manueel
     * @param name
     * @return
     */
    public Float bestPathTo(String name) {
        //base
        if (visited || connections.isEmpty())
            return (float) 0;
        //when found
        if (this.name == name)
            return this.chance;
        //when not found
        else {
            Float max = (float) 0;
            for(Node n: connections) {
                max *= Float.max(max, bestPathTo(name));
            }
            return max;
        }
    }

    /**
     *
     */
    public Float dijkstra() {

    }
}
