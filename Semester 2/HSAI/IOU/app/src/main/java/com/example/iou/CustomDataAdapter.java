package com.example.iou;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageButton;
import android.widget.TextView;

import java.util.ArrayList;

public class CustomDataAdapter extends BaseAdapter {
    private final ArrayList<String> persons;
    private ArrayList<Float> costs;
    private LayoutInflater inflater;

    public CustomDataAdapter(Context applicationContext, ArrayList<String> persons, ArrayList<Float> costs) {
        this.persons = persons;
        this.costs = costs;
        inflater = (LayoutInflater.from(applicationContext));
    }

    @Override
    public int getCount() {
        return persons.size();
    }

    @Override
    public Object getItem(int i) {
        return null;
    }

    @Override
    public long getItemId(int i) {
        return 0;
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if (view == null)
            view = inflater.inflate(R.layout.listview_activity, viewGroup, false);

        TextView person = view.findViewById(R.id.name);
        person.setText(persons.get(i));
        TextView cost = view.findViewById(R.id.cost);
        cost.setText(String.format("€%s", costs.get(i).toString()));
        ImageButton button = view.findViewById(R.id.delete);
        button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                persons.remove(i);
                costs.remove(i);
                notifyDataSetChanged();
            }
        });

        return view;
    }
}
