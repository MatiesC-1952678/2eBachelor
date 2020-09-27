package com.company;

import java.util.Vector;

class Matrix {
    private int[][] matrix;
    Matrix() {
        matrix = new int[][]{{0, 0, 0},{0, 0, 0},{0, 0, 0}};
    }
    Matrix(int[][] intArray) {
        matrix = intArray;
    }
    public void increment() {
        for (int i = 0; i < 3; i++) {
            for (int j = 0; j < 3; j++) {
                matrix[i][j]++;
            }
        }
    }

    public int get(int i, int j) {
        return matrix[i][j];
    }

    public void print() {
        for (int i = 0; i < 3; i++) {
            System.out.print("{");
            for (int j = 0; j < 3; j++) {
                System.out.print(matrix[i][j]);
                if (j < 2) {
                    System.out.print(", ");
                }
            }
            System.out.println("}");
        }
        System.out.println();
    }

    public void add(int num) {
        for (int i = 0; i < 3; i++) {
            for (int j = 0; j < 3; j++) {
                matrix[i][j] += num;
            }
        }
    }

    public void add(Matrix secondMatrix) {
        for (int i = 0; i < 3; i++) {
            for (int j = 0; j < 3; j++) {
                matrix[i][j] += secondMatrix.get(i, j);
            }
        }
    }
}

public class Main {

    public static void main(String[] args) {
        Matrix myMatrix = new Matrix();
        myMatrix.increment();
        myMatrix.print();
        Matrix secMatrix = new Matrix();
        secMatrix.add(2);
        myMatrix.add(secMatrix);
        myMatrix.print();
    }
}
