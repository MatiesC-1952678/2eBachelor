package com.example.myfirstapp;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.widget.ArrayAdapter;
import android.widget.ListView;

import java.lang.reflect.Array;
import java.util.ArrayList;
import java.util.Arrays;

public class MainActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        /*MyAdapter adapter = new MyAdapter();
        ListView listView = (ListView) findViewById(R.id.list_view);
        listView.setAdapter(adapter);*/
        ArrayList<String> stringArray = new ArrayList<>(Arrays.asList("test1", "test2", "test3"));
        ArrayAdapter<String> adapter = new ArrayAdapter<>(this, android.R.layout.simple_list_item_1, stringArray);
        ListView listView = findViewById(R.id.list_view);
        listView.setAdapter(adapter);


    }
}