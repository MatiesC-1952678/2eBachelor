package com.example.iou;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;

public class AddItem extends AppCompatActivity {
    public static final String ADD_PERSON_NAME = "add_person_name";
    public static final String ADD_PERSON_COST = "add_person_cost";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_add_item);
    }

    public void addPersonCost(View view) {
        Intent intent = new Intent(this, MainActivity.class);
        String name = ((EditText) findViewById(R.id.addItemName)).getText().toString();
        Float cost = Float.parseFloat(((EditText) findViewById(R.id.addItemCost)).getText().toString());
        intent.putExtra(ADD_PERSON_NAME, name);
        intent.putExtra(ADD_PERSON_COST, cost);
        startActivity(intent);
    }
}