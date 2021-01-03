package com.company;

import java.util.ArrayList;

class Node {
    Node left;
    Node right;
    Integer value;

    public Node(Node left, Node right, Integer value) {
        this.left = left;
        this.right = right;
        this.value = value;
    }

    public boolean isLeave() {
        return left == null && right == null;
    }

    public Integer getValue() {
        return value;
    }

    public ArrayList<Node> getChildren() {
        ArrayList<Node> result = new ArrayList<>();
        result.add(left);
        result.add(right);
        return result;
    }
}

public class AB {

    public Integer alphaBeta(Node node, Integer depth, Integer a, Integer b, Boolean maximizing) {
        if (depth == 0 || node.isLeave()) {
            return node.getValue();
        }
        if (maximizing) {
            Integer maxValue = Integer.MIN_VALUE;
            for (Node n: node.getChildren()) {
                maxValue = Integer.max(maxValue, alphaBeta(n, depth-1, a, b, false));
                a = Integer.max(a, maxValue);
                if (a >= b)
                    break;
            }
            return maxValue;
        } else {
            Integer maxValue = Integer.MAX_VALUE;
            for (Node n: node.getChildren()) {
                maxValue = Integer.min(maxValue, alphaBeta(n, depth-1, a, b, true));
                a = Integer.min(b, maxValue);
                if (b <= a)
                    break;
            }
            return maxValue;
        }
    }
}
