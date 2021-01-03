package com.company;

import java.util.ArrayList;

public class Floyd {

    public void floyd(AdjacencyMatrix m) {
        int n = m.getAantalknopen();
        Integer[][] T = new Integer[n][n];
        Integer[][] P = new Integer[n][n];
        doFloyd(m.getKostMatrix(), T, P, n);

        ArrayList<String> labels = m.getLabelArray();
        floydPath(P, labels.indexOf("Ingrediënten wegen"), labels.indexOf("Taart bakken"));
    }
    private void doFloyd(Integer[][] G, Integer[][] T, Integer[][] P, int n) {

        for (int v = 0; v < n; v++) {
            for (int w = 0; w < n; w++) {
                T[v][w] = G[v][w];
                P[v][w] = -1;
            }
        }

        for (int k = 0; k < n; k++) {
            for (int v = 0; v < n; v++) {
                for (int w = 0; w < n; w++) {
                    if (T[v][k] != null && T[k][w] != null && T[v][w] != null) {
                        if (T[v][k] + T[k][w] < T[v][w]) {
                            T[v][w] = T[v][k] + T[k][w];
                            P[v][w] = k;
                        }
                    }
                }
            }
        }

    }

    private void floydPath(Integer[][] P, int v, int w) {
        int k = P[v][w];
        if (k != -1) {
            floydPath(P, v, k);
            System.out.print(k+" ");
            floydPath(P, k, w);
        }
    }
}
