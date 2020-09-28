package com.company;

class Person {
    private String m_name;
    private String m_surname;
    private char m_gender;

    public String getname() {
        return m_name;
    }
    public String getsurname() {
        return m_surname;
    }
    public char getgender() {
        return m_gender;
    }
    public void setname(String name) {
        this.m_name = name;
    }
    public void setsurname(String surname) {
        this.m_surname = surname;
    }
    public void setgender(char gender) {
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

    public boolean equals(Person other) {
        return m_name.equals(other.getname()) && m_surname.equals(other.getsurname()) && m_gender == other.getgender();
    }
}

public class Main {

    public static void main(String[] args) {
	    Person jonnyBob = new Person();
	    jonnyBob.print();
	    jonnyBob.setname("Jonny");
	    jonnyBob.setsurname("Bob");
	    jonnyBob.setgender('m');
        jonnyBob.print();

        Person jimmyBob = new Person("Jimmy", "Bob", 'm');
        Person jonnyBob2 = new Person("Jonny", "Bob", 'm');

        System.out.println(jonnyBob.equals(jimmyBob));
        System.out.println(jonnyBob.equals(jonnyBob2));

        /*  Test to see if the ALIASING works here
        String test = jonnyBob.getM_name();
        test = "altered / hacked";
        jonnyBob.print();
         */
    }
}
