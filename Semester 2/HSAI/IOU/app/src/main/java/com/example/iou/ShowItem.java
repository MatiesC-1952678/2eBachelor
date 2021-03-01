package com.example.iou;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.widget.EditText;
import android.widget.TextView;

import org.w3c.dom.Text;

public class ShowItem extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_show_item);

        Intent intent = getIntent();
        String name = intent.getStringExtra(MainActivity.PERSON_NAME);
        Float cost = intent.getFloatExtra(MainActivity.PERSON_COST, 0.0f);

        TextView nameText = findViewById(R.id.showItemName);
        TextView costText = findViewById(R.id.showItemCost);
        nameText.setText(name);
        costText.setText(cost.toString());
    }
}