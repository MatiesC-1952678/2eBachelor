package com.example.iou;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import org.w3c.dom.Text;

public class ShowItem extends AppCompatActivity {
    public static final String EDIT_PERSON_ID = "previous_person_name";
    public static final String EDIT_PERSON_NAME = "edit_person_name";
    public static final String EDIT_PERSON_COST = "edit_person_cost";
    private String id;
    private EditText nameText;
    private EditText costText;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_show_item);

        Intent intent = getIntent();
        id = intent.getStringExtra(MainActivity.PERSON_ID);
        String name = intent.getStringExtra(MainActivity.PERSON_NAME);
        Float cost = intent.getFloatExtra(MainActivity.PERSON_COST, 0.0f);

        nameText = findViewById(R.id.showItemName);
        costText = findViewById(R.id.showItemCost);
        nameText.setText(name);
        costText.setText(String.format("%.2f", cost));
    }

    /**
     * The function that will be called when the "opslaan" knop is pressed
     * this will result in the opening fo the mainactivity activity with an intent (values of the edited item)
     * @param view
     */
    public void editPersonCost(View view) {
        String newName = nameText.getText().toString();
        String cost = costText.getText().toString();

        if (!newName.equals("")) {
            float floatCost;
            if (cost.equals(""))
                floatCost = 0.0f;
            else
                floatCost = Float.parseFloat(cost);
            Intent intent = new Intent(this, MainActivity.class);
            intent.putExtra(EDIT_PERSON_ID, id);
            intent.putExtra(EDIT_PERSON_NAME, newName);
            intent.putExtra(EDIT_PERSON_COST, floatCost);
            startActivity(intent);
        } else {
            Toast toast = Toast.makeText(this, "Vul een naam in", Toast.LENGTH_SHORT);
            toast.show();
        }
    }
}