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
    private final ArrayList<String> persons; //init data
    private final ArrayList<Float> costs; //init data
    private final LayoutInflater inflater;
    private deleteButtonInterface listener;

    public CustomDataAdapter(Context applicationContext, ArrayList<String> persons, ArrayList<Float> costs) {
        this.persons = persons;
        this.costs = costs;
        inflater = (LayoutInflater.from(applicationContext));
    }

    public void setListener(deleteButtonInterface listener) {
        this.listener = listener;
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
        if (view == null) {
            view = initView(i, viewGroup);
        }

        TextView person = view.findViewById(R.id.name);
        person.setText(persons.get(i));
        TextView cost = view.findViewById(R.id.cost);
        cost.setText(String.format("€%s", costs.get(i).toString()));

        return view;
    }

    /**
     * when the view is not yet initialized, the layout inflater will produce all the components for a
     * smoother scrolling experience (meaning the same sizes of components will be produced)
     * AND
     * the button listener will be initialized
     * @param i
     * @param viewGroup
     * @return
     */
    private View initView(int i, ViewGroup viewGroup) {
        View view = inflater.inflate(R.layout.listview_activity, viewGroup, false);
        ImageButton button = view.findViewById(R.id.delete);
        button.setOnClickListener(v -> {
            if (listener != null)
            {
                listener.deleteButtonMethod(i, persons.get(i), costs.get(i));
            }
        });
        return view;
    }
}

