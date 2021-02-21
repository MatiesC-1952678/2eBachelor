package com.company;

public class Main {

    public static void main(String[] args) {
	    Taak root = new Taak("Ingrediënten wegen", 5);
	    Taak schil = new Taak("Appels schillen", 10);
	    Taak snijd = new Taak("Appels snijden", 3);
	    Taak spring = new Taak("Springvorm vullen", 5);
	    Taak bak = new Taak("Taart bakken", 45);
	    Taak kneed = new Taak("Deeg kneden", 10);
	    root.setVolgendeTaak(schil);
	    root.setVolgendeTaak(kneed);
	    schil.setVolgendeTaak(snijd);
	    snijd.setVolgendeTaak(spring);
	    spring.setVolgendeTaak(bak);
	    kneed.setVolgendeTaak(spring);

	    AdjacencyMatrix m = root.getAdjacencyMatrix();
	    Floyd f = new Floyd();
	    f.floyd(m);

    }
}
