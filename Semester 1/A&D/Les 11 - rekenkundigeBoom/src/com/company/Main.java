package com.company;

public class Main {

    public static void main(String[] args) {
	    Tree root = new Tree(
	            new Tree(
	                    new Tree(
	                            new Tree(null, null, '1'),
                                new Tree(null, null, '2'),
                                '+'),
                        new Tree(null, null, '3'),
                        '*'),
                new Tree(null, null, '4'),
                '-'
        );
	    root.prefix();
	    System.out.println();
	    root.infix();
        System.out.println();
	    root.postfix();
    }
}
