package com.example.iou;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.TextView;

import java.util.ArrayList;
import java.util.Arrays;

public class MainActivity extends AppCompatActivity {
    public final static String PERSON_NAME = "person_name";
    public final static String PERSON_COST = "person_cost";
    private ArrayList<String> persons = new ArrayList<>(Arrays.asList("jane", "margret", "john"));
    private ArrayList<Float> costs =  new ArrayList<>(Arrays.asList(40.2f, 20.30f, 77.50f));

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        initListView();
        insertAdded();
        calculateTotal();
    }

    private void initListView() {
        ListView list = findViewById(R.id.listView);
        CustomDataAdapter cda = new CustomDataAdapter(this, persons, costs);
        list.setAdapter(cda);

        list.setOnItemClickListener(messageClickedHandler);
    }
    private void insertAdded() {
        Intent intent = getIntent();
        String name_last_added = intent.getStringExtra(AddItem.ADD_PERSON_NAME);
        Float cost_last_added = intent.getFloatExtra(AddItem.ADD_PERSON_COST, 0.0f);
        if (name_last_added != null) {
            persons.add(name_last_added);
            costs.add(cost_last_added);
        }
    }
    private void calculateTotal() {
        Float total = 0f;
        for (int i = 0; i < costs.size(); i++) {
            total += costs.get(i);
        }
        final String pre = "Totale Schuld: €";
        TextView totalText = findViewById(R.id.total);
        totalText.setText(String.format("%s%s", pre, total.toString()));
    }

    private AdapterView.OnItemClickListener messageClickedHandler = (parent, v, position, id) -> {
        Intent intent = new Intent(MainActivity.this, ShowItem.class);
        intent.putExtra(PERSON_NAME, persons.get(position));
        intent.putExtra(PERSON_COST, costs.get(position));
        startActivity(intent);
    };

    public void goToAddItemActivity(View view) {
        Intent intent = new Intent(MainActivity.this, AddItem.class);
        startActivity(intent);
    }
}