package Opgave_10_4;
import java.io.*;
import java.util.Arrays;
import java.util.HashMap;
import java.util.LinkedList;

public class BestandLezer {
    HashMap<Integer, LinkedList<String>> $hash;

    public LinkedList<String> stringToList(String zin) {
        return new LinkedList<>(Arrays.asList(zin.split(" ")));
    }

    public void indexeer(File bestand) {
        $hash = new HashMap<>();
        try {
            BufferedReader br = new BufferedReader(new FileReader(bestand));
            String st;
            int regel = 1;

            while ((st = br.readLine()) != null) {
                $hash.put(regel++, stringToList(st));
            }
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    public void countWords() {
        int regel = 1;
        for (LinkedList<String> zin : $hash.values()) {
            if (!zin.get(0).equals(""))
                System.out.println("In regel " + regel++ + " zijn er " + zin.size() + " woorden.");
            else
                System.out.println("In regel " + regel++ + " staat er een witregel.");
        }
    }

    public void findWordLocations(String wordToFind) {
        int regelCount = 1;
        for (LinkedList<String> zin : $hash.values()) {
            int woordCount = 1;
            for (String woord : zin) {
                if (woord.equals(wordToFind))
                    System.out.println("Woord gevonden op regel: " + regelCount + "\nMet als volgnummer: " + woordCount);
                ++woordCount;
            }
            ++regelCount;
        }
    }

    public void findTwoWords(String word1, String word2) {
        int regelCount = 1;
        for (LinkedList<String> zin : $hash.values()) {
            for (int i = 0; i < zin.size() - 1; ++i) {
                if (zin.get(i).equals(word1) && zin.get(i+1).equals(word2))
                    System.out.println("Opeen volgende woorden gevonden op regel: " + regelCount + "\nMet als volgnummer: " + (i+1) + " en " + (i+2));
            }
            ++regelCount;
        }
    }


}
