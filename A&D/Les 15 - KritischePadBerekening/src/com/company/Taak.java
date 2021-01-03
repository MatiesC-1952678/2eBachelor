package com.company;

import java.util.ArrayList;

public class Taak {
    ArrayList<Taak> volgendeTaken = new ArrayList<>();
    String label;
    Integer kost;

    public Taak(String label, Integer kost) {
        this.label = label;
        this.kost = kost;
    }

    public void setVolgendeTaak(Taak volgendeTaken) {
        this.volgendeTaken.add(volgendeTaken);
    }

    public ArrayList<Taak> getVolgendeTaken() {
        return volgendeTaken;
    }

    /**
     * PRE: always do from root
     */
    public AdjacencyMatrix getAdjacencyMatrix() {
        AdjacencyMatrix matrix = new AdjacencyMatrix(6);
        insertAllLabels(matrix);
        matrix.printLabels();
        insertKosts(matrix);
        matrix.printMatrix();
        return matrix;
    }

    private void insertAllLabels(AdjacencyMatrix matrix) {
        matrix.addLabel(label);
        for (Taak t : volgendeTaken) {
            t.insertAllLabels(matrix);
        }
    }

    private void insertKosts(AdjacencyMatrix matrix) {
        for(Taak t : volgendeTaken) {
            if (t.volgendeTaken.isEmpty())
                matrix.addKost(this.label, t.label, this.kost+t.kost);
            else
                matrix.addKost(this.label, t.label, this.kost);
            t.insertKosts(matrix);
        }
    }
}
