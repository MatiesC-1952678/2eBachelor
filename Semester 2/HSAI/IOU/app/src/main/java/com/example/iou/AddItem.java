package com.example.iou;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

public class AddItem extends AppCompatActivity {
    public static final String ADD_PERSON_NAME = "add_person_name";
    public static final String ADD_PERSON_COST = "add_person_cost";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_add_item);
    }

    /**
     * The function that will be called when the "opslaan" knop is pressed
     * this will result in the opening fo the mainactivity activity with an intent (values of the added item)
     * @param view
     */
    public void addPersonCost(View view) {
        String name = ((EditText) findViewById(R.id.addItemName)).getText().toString();
        String cost = ((EditText) findViewById(R.id.addItemCost)).getText().toString();

        if (!name.equals("")) {
            float floatCost;
            if (cost.equals(""))
                floatCost = 0.0f;
            else
                floatCost = Float.parseFloat(cost);
            Intent intent = new Intent(this, MainActivity.class);
            intent.putExtra(ADD_PERSON_NAME, name);
            intent.putExtra(ADD_PERSON_COST, floatCost);
            startActivity(intent);
        } else {
            Toast toast = Toast.makeText(this, "Vul een naam in", Toast.LENGTH_SHORT);
            toast.show();
        }
    }
}