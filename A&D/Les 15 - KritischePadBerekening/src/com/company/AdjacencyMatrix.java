package com.company;

import java.util.ArrayList;

public class AdjacencyMatrix {
    private Integer aantalknopen;
    private Integer[][] kostMatrix;
    private ArrayList<String> labelArray = new ArrayList<>();;

    public AdjacencyMatrix(Integer aantalknopen) {
        this.aantalknopen = aantalknopen;
        kostMatrix = new Integer[aantalknopen][aantalknopen];
    }

    public boolean addLabel(String label) {
        if (!labelArray.contains(label)) {
            labelArray.add(label);
            return true;
        }
        return false;
    }

    public void addKost(String taak1, String taak2, Integer kost) {
        int indexTaak1 = labelArray.indexOf(taak1);
        int indexTaak2 = labelArray.indexOf(taak2);
        kostMatrix[indexTaak1][indexTaak2] = kost;
    }

    public Integer getAantalknopen() {
        return aantalknopen;
    }

    public Integer[][] getKostMatrix() {
        return kostMatrix;
    }

    public ArrayList<String> getLabelArray() {
        return labelArray;
    }

    public void printLabels() {
        for (String s: labelArray)
            System.out.print(s+" | ");
        System.out.println();
    }

    public void printMatrix() {
        for (Integer[] bVector: kostMatrix) {
            for (Integer b: bVector) {
                if (b == null)
                    System.out.print("|0\t");
                else
                    System.out.print("|"+b+"\t");
            }
            System.out.println();
        }
    }
}
