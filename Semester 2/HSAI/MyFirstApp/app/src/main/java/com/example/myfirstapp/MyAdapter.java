package com.example.myfirstapp;

import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import java.util.ArrayList;

public class MyAdapter extends BaseAdapter {

    ArrayList<String> stringArray = new ArrayList<>();
    MyAdapter() {
        stringArray.add("test1");
        stringArray.add("test2");
        stringArray.add("fuck the pattern I do what I wanna do");
    }

    @Override
    public int getCount() {
        return 0;
    }

    @Override
    public Object getItem(int position) {
        return null;
    }

    @Override
    public long getItemId(int position) {
        return 0;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        ((TextView) convertView.findViewById(android.R.id.text1)).setText(stringArray.get(position));
        return convertView;
    }
}
