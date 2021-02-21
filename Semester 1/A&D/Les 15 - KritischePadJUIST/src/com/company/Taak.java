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

    public int criticalDepth(int depth) {
        //BASISSTAP
        if (this.volgendeTaken.isEmpty())
            return depth;
        //RECURSIESTAP
        int maximum = 0;
        for (Taak t: volgendeTaken) {
            maximum = Integer.max(maximum, t.criticalDepth(depth+1));
        }
        return maximum;
    }

    public int criticalCost(int cost) {
        //BASISSTAP
        if (this.volgendeTaken.isEmpty())
            return cost+this.kost;
        //RECURSIESTAP
        int maximum = 0;
        for (Taak t: volgendeTaken) {
            maximum = Integer.max(maximum, t.criticalCost(cost+this.kost));
        }
        return maximum;
    }
}
