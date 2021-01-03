package com.company;

public class Node {
    Character character;
    Node left;
    Node right;

    public Node(Character character, Node left, Node right) {
        this.character = character;
        this.left = left;
        this.right = right;
    }

    public Character getCharacter() {
        return character;
    }

    public Node getLeft() {
        return left;
    }

    public Node getRight() {
        return right;
    }

    /*
              *
             /
            *
           / \
          *   *

     */

    public void encodeZin(Node node, String string) {
        char[] charArray = string.toCharArray();
        for (char c: charArray) {
            encode(node, c);
        }
    }

    public void encode(Node node, Character c) {
        if (node.left == null && node.right == null)
            return;
        else {
            if (inLeft(node.left, c)) {
                //System.out.print('0');
                encode(node.left, c);
            } else {
                //System.out.print('1');
                encode(node.right, c);
            }
        }

    }

    private boolean inLeft(Node node, Character c) {
        if (node.left == null && node.right == null) {
            if (node.character == c)
                return true;
            else
                return false;
        } else {
            return inLeft(node.left, c) || inLeft(node.right, c);
        }
    }
}
