package com.company;

class Person {
    private String m_name;
    private String m_surname;
    private char m_gender;

    public String getM_name() {
        return m_name;
    }
    public String getM_surname() {
        return m_surname;
    }
    public char getM_gender() {
        return m_gender;
    }
    public void setM_name(String name) {
        this.m_name = name;
    }
    public void setM_surname(String surname) {
        this.m_surname = surname;
    }
    public void setM_gender(char gender) {
        this.m_gender = gender;
    }
    public void print() {
        System.out.println(m_name +" "+ m_surname + "\n" + m_gender);
    }

    Person() {
        this.m_name = "name";
        this.m_surname = "surname";
        this.m_gender = 'u'; //unassigned
    }
    Person(String name, String surname, char gender) {
        this.m_name = name;
        this.m_surname = surname;
        this.m_gender = gender;
    }
}

public class Main {

    public static void main(String[] args) {
	    Person jonnyBob = new Person();
	    jonnyBob.print();
	    jonnyBob.setM_name("Jonny");
	    jonnyBob.setM_surname("Bob");
	    jonnyBob.setM_gender('m');
        jonnyBob.print();

        /*  Test to see if the ALIASING works here
        String test = jonnyBob.getM_name();
        test = "altered / hacked";
        jonnyBob.print();
         */
    }
}
