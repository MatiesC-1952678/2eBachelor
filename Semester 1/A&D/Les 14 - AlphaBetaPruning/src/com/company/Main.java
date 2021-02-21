package com.company;

public class Main {

    public static void main(String[] args) {
        Node node =
                new Node(
                        new Node(
                                new Node(
                                        new Node(null, null, 6),
                                        new Node(null, null, 2),
                                        null
                                ),
                                new Node(
                                        new Node(null, null, 8),
                                        new Node(null, null, 4),
                                        null
                                ),
                                null
                        ),
                        new Node(
                                new Node(
                                        new Node(null, null, 1),
                                        new Node(null, null, 2),
                                        null
                                ),
                                new Node(
                                        new Node(null, null, 8),
                                        new Node(null, null, 9),
                                        null
                                ),
                                null),
                        null);
	    AB ab = new AB();
	    System.out.println(ab.alphaBeta(node, 3, Integer.MIN_VALUE, Integer.MAX_VALUE, true));
	    System.out.println(ab.alphaBeta(node.left, 2, Integer.MIN_VALUE, Integer.MAX_VALUE, false));
	    System.out.println(ab.alphaBeta(node.left.left, 1, Integer.MIN_VALUE, Integer.MAX_VALUE, true));
        node =
                new Node(
                        new Node(
                                new Node(
                                        new Node(null, null, 10),
                                        new Node(null, null, 5),
                                        null
                                ),
                                new Node(
                                        new Node(null, null, 7),
                                        new Node(null, null, 2),
                                        null
                                ),
                                null
                        ),
                        new Node(
                                new Node(
                                        new Node(null, null, 6),
                                        new Node(null, null, 4),
                                        null
                                ),
                                new Node(
                                        new Node(null, null, 10),
                                        new Node(null, null, 9),
                                        null
                                ),
                                null),
                        null);
        System.out.println(ab.alphaBeta(node, 3, Integer.MIN_VALUE, Integer.MAX_VALUE, true));
        System.out.println(ab.alphaBeta(node.left, 2, Integer.MIN_VALUE, Integer.MAX_VALUE, false));
        System.out.println(ab.alphaBeta(node.left.right, 1, Integer.MIN_VALUE, Integer.MAX_VALUE, true));

    }
}
