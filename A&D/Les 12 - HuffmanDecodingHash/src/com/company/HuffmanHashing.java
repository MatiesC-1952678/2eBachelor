package com.company;

import java.util.HashMap;
import java.util.Set;

public class HuffmanHashing {
    private final HashMap<Character, String> encodeTable = new HashMap<>();
    private final HashMap<String, Character> decodeTable = new HashMap<>();

    public HuffmanHashing() {
        encodeTable.put(' ', "010");
        encodeTable.put('a', "00");
        encodeTable.put('o', "11");
        encodeTable.put('p', "011");
        encodeTable.put('t', "10");

        decodeTable.put("010", ' ');
        decodeTable.put("00", 'a');
        decodeTable.put("11", 'o');
        decodeTable.put("011", 'p');
        decodeTable.put("10", 't');

    }

    public void encode(String phrase) {
        for(Character c: phrase.toCharArray()) {
            encodeTable.get(c);
        }
        //System.out.println();
    }

    public void decode(String bitString) {
        int i = 0;
        Set<String> keySet = decodeTable.keySet();
        while(i < bitString.length()) {
            String twoChar = bitString.substring(i, i+2);
            if (keySet.contains(twoChar)) {
                i += 2;
                System.out.print(decodeTable.get(twoChar));
            } else {
                String threeChar = bitString.substring(i, i+3);
                if (keySet.contains(threeChar)) {
                    i += 3;
                    System.out.print(decodeTable.get(threeChar));
                }
            }
        }
        System.out.println();
    }
}
