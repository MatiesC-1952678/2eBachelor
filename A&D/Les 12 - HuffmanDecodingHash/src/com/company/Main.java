package com.company;

public class Main {

    public static void main(String[] args) {
	    HuffmanHashing huffmanHashing = new HuffmanHashing();
	    Monitor monitor = new Monitor();
	    Node root = new Node(null,
						new Node(null,
								new Node('a', null, null),
								new Node(null,
										new Node(' ', null, null),
										new Node('p', null, null)
										)),
						new Node(null,
								new Node('t', null, null),
								new Node('o', null, null)
								)
						);

	    int loop = 1000000;
	    for(int i = 0; i < loop; i++) {
			monitor.start();
			root.encodeZin(root, "opa at aap op");
			monitor.end();
		}
	    monitor.average();
	    /*
	    huffmanHashing.encode("opa at aap op");
	    huffmanHashing.decode("11011000100010010000001101011011");
	    huffmanHashing.encode("aaaaaat toa popop popa toooot");
	    huffmanHashing.decode("0000000000001001010110001001111011110110100111101100010101111111110");
	    */

		for(int i = 0; i < loop; i++) {
			monitor.start();
			huffmanHashing.encode("opa at aap op");
			monitor.end();
		}
		monitor.average();

    }
}
