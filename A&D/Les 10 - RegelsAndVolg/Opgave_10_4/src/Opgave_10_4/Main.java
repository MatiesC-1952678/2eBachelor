package Opgave_10_4;

import java.io.File;

public class Main {

    public static void main(String[] args) {
	// write your code here
        BestandLezer lezer = new BestandLezer();
        lezer.indexeer(new File("Lorem_Ispum.txt"));
        //lezer.countWords();
        //lezer.findWordLocations("the");
        lezer.findTwoWords("written", "in");
    }
}
